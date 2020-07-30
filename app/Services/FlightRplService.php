<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/26/2020
 * Time: 9:42 PM
 */

namespace App\Services;

use App\Models\FlightRpl;
use Illuminate\Support\Facades\DB;
use App\Components\ErrorCode;
use Illuminate\Support\Facades\Config;
use App\Components\EaseFlightValidation;
use App\Components\Exception as MyException;
use App\Components\Auth;
use App\Models\Status;
use App\Models\UserType;
use App\Models\SystemFlight;
use App\Models\SystemFightType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Components\ValidationException;
use App\Models\Operator;

class FlightRplService
{
    protected $system_flight;

    public function __construct()
    {
        $this->system_flight = Config::get('constant_system_flight_type');
    }

    /**
     * @param $params
     * @param Auth $auth
     * @return mixed
     * @throws MyException
     */
    public function createFlightPlan($params, Auth $auth)
    {
        if (empty($this->system_flight)){
            throw new MyException('Could not find system config', ErrorCode::INTERNAL_ERROR);
        }

        EaseFlightValidation::forceValidateRpl($params);

        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($params, $auth){
                // create flight

                $params['operator_id'] = $auth->getId();
                if($auth->getType() == UserType::TYPE_OPERATOR){
                    $user = Operator::find($auth->getId());
                    $params['departure_airport_id'] = $user->airport->system_airport->id;
                }
                $flight = FlightRpl::create($params);

                if(empty($flight)){
                    throw (new MyException('Create Flight Record Failed', ErrorCode::INTERNAL_ERROR));
                }

                // store for system flight
                // build params for system flight ats
                $system_flight_params = [
                    'flight_id' => $flight->id,
                    'system_flight_types_id' => $this->system_flight['rpl']['id'],
                    'status_id' => isset($params['status_id']) ? $params['status_id'] : 1
                ];

                (new SystemFlightService())::save($system_flight_params, $auth);

                (new FlightRplFlightsService())::createFlights($params['flights'], $flight->id, $system_flight_params, true);

                return $flight;
            });

    }

    public function getAllSent(Auth $auth)
    {
        $flights = FlightRpl::where('status_id', Status::ACTIVE)
            ->where('operator_id', $auth->getId())
            ->with('flights.days')
            ->orderBy('created_at', 'desc')->get();
        return $flights;
    }

    public function getOneSent(Auth $auth, $id)
    {
        if($auth->getType() == UserType::TYPE_AIS)
        {
            $flight = FlightRpl::where('id', $id)
                ->where('status_id', Status::ACTIVE)
                ->with(['flights.days', 'operator.organisation'])
                ->first();
            return $flight;
        }

        $flight = FlightRpl::where('id', $id)
            ->where(function($query){
                $query->where('status_id', Status::ACTIVE)
                    ->orWhere('status_id', Status::DECLINED);
            })->with('flights.days')->where('operator_id', $auth->getId())
            ->first();
        return $flight;

    }

    public function draft($params, Auth $auth)
    {
        if (empty($this->system_flight)) {
            throw new MyException('Could not find system config', ErrorCode::INTERNAL_ERROR);
        }


        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($params, $auth) {
                // create flight

                $params['operator_id'] = $auth->getId();
                $params['status_id'] = Status::DRAFTED;

                $flight = FlightRpl::create($params);
                if($auth->getType() == UserType::TYPE_OPERATOR){
                    $user = Operator::find($auth->getId());
                    $params['departure_airport_id'] = $user->airport->system_airport->id;
                }
                if (empty($flight)) {
                    throw (new MyException('Create Flight Record Failed', ErrorCode::INTERNAL_ERROR));
                }

                // store for system flight
                // build params for system flight ats
                $system_flight_params = [
                    'flight_id' => $flight->id,
                    'system_flight_types_id' => $this->system_flight['rpl']['id'],
                    'status_id' => Status::DRAFTED,
                    'user_type_id' =>  $auth->getType()
                ];

                (new SystemFlightService())::save($system_flight_params, $auth);

                (new FlightRplFlightsService())::createFlights(isset($params['flights'])
                    ? $params['flights'] : [],
                    $flight->id, $system_flight_params, false);

                return $flight;

            });
    }

    /**
     * @param $id
     * @return mixed
     * Return single drafted flight
     */
    public function getOneDraft(Auth $auth, $id)
    {
        $flight = FlightRpl::where('id', $id)
            ->where('status_id', Status::DRAFTED)
            ->where('operator_id', $auth->getId())
            ->with('flights.days')
            ->first();
        return $flight;
    }

    /**
     * @param $user_id
     * @param $flight_id
     * @param $params
     */
    public function updateDraft($flight_id, $params, $auth)
    {
        $flight = null;
        $system_flight = null;
        $forceValidation = false;

        $validator = Validator::make(['flight_id' => $flight_id], [
            'flight_id' => [
                'required',
                'numeric',
                Rule::exists('flight_rpl', 'id')
                    ->where(function($query){
                        $query->where(function($query){
                            $query->where('status_id', Status::DRAFTED)
                                ->orWhere('status_id', Status::DECLINED);
                        });
                    })->where('operator_id', $auth->getId())
            ]
        ],[
            'flight_id.exists' => 'This flight may not exist or it has been approved.'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($params, $auth, $flight_id, $forceValidation) {
                if (isset($params['send']) && $params['send'] == '1') {

                    EaseFlightValidation::forceValidateRpl($params);
                    $forceValidation = true;

                    $params['status_id'] = Status::ACTIVE;
                    $flight = FlightRpl::find($flight_id);
                    $system_flight = SystemFlight::where('flight_id', $flight_id)
                        ->where('system_flight_types_id',$this->system_flight['rpl']['id'])
                        ->get();
                    $system_flight[0]->status_id = Status::ACTIVE;
                    $system_flight[0]->save();
                    $flight->update($params);

                } else {

                    $flight = FlightRpl::find($flight_id);
                    $flight->update($params);
                }

                if (isset($params['flights'])) {
                    (new FlightRplFlightsService())->updateFlights($params['flights'], $flight->id, $forceValidation);
                }

                return $flight->refresh();
            }

        );
    }

    /**
     * @param $user_id
     * @param $user_type_id
     * @param $params
     * @return string
     */
    public function approve(Auth $auth, $params)
    {
        // include routes
        // time and dates accepted
        if($auth->getType() != UserType::TYPE_AIS)
        {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }
        $extra_param = [
            'user_id' => $auth->getId(),
            'flight_id' => isset($params['flight_id']) ? $params['flight_id']: '',
            'addressees' => isset($params['addressees']) ? $params['addressees']: [],
        ];

        $validator = Validator::make($extra_param, [
            'user_id' => 'required|numeric|exists:ais,id',
            'flight_id' => [
                'required',
                'numeric',
                Rule::exists('system_flights', 'flight_id')
                    ->where('system_flight_types_id', SystemFightType::RPL)
                    ->where('status_id', Status::ACTIVE)
            ],
            'addressees' => 'sometimes|array'
        ], [
            'user_id.exists' => 'User not authorized to approve ATS flight',
            'flight_id.exists' => 'Invalid Flight'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $flight = FlightRpl::find($params['flight_id']);
        $system_flight = SystemFlight::where('flight_id', $params['flight_id'])
            ->where('system_flight_types_id',$this->system_flight['rpl']['id'])
            ->get();

        if(empty($flight) && empty($system_flight)){
            throw (new MyException('Flight record not found', ErrorCode::RECORD_NOT_EXISTING));
        }

        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($system_flight, $flight, $params, $auth) {
                $system_flight[0]->status_id = Status::APPROVED;
                $flight->status_id = Status::APPROVED;
                $flight->accepted_by = $auth->getId();

                $system_flight[0]->save();
                $flight->save();

                if(isset($params['addressees'])){
                    (new FlightRplAddresseesService())::saveAddressees($params['addressees']);
                }

                return $flight->refresh();
            });
    }

    /**
     * @param Auth $auth
     * @return mixed
     */
    public function getAllApproved(Auth $auth)
    {
        $flights = FlightRpl::where('status_id', Status::APPROVED)
            ->where('operator_id', $auth->getId())
            ->orderBy('created_at', 'desc')->get();
        return $flights;
    }

    /**
     * @param $user_id
     * @param $params
     * @return string
     * @throws MyException
     */
    public function decline(Auth $auth, $params)
    {
        if($auth->getType() != UserType::TYPE_AIS)
        {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }

        $extra_param = ['user_id' => $auth->getId(),
            'official_remarks' => isset($params['official_remarks']) ? $params['official_remarks']: '',
            'flight_id' => isset($params['flight_id']) ? $params['flight_id']: ''
        ];

        $validator = Validator::make($extra_param, [
            'user_id' => 'required|numeric|exists:ais,id',
            'flight_id' => [
                'required',
                'numeric',
                Rule::exists('system_flights', 'flight_id')
                    ->where('system_flight_types_id', SystemFightType::RPL)
                    ->where('status_id', Status::ACTIVE)
            ],
            'official_remarks' => 'required'
        ], [
            'user_id.exists' => 'User not authorized to approve ATS flight',
            'flight_id.exists' => 'Invalid Flight'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $flight = FlightRpl::find($params['flight_id']);
        $system_flight = SystemFlight::where('flight_id', $params['flight_id'])
            ->where('system_flight_types_id',$this->system_flight['rpl']['id'])
            ->get();

        if(empty($flight) && empty($system_flight)){
            throw (new MyException('Flight record not found', ErrorCode::RECORD_NOT_EXISTING));
        }

        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($system_flight, $flight, $params) {

                $system_flight[0]->status_id = Status::DECLINED;
                $flight->status_id = Status::DECLINED;
                $flight->official_remarks = $params['official_remarks'];

                $system_flight[0]->save();
                $flight->save();


                return "RPL Flight Plan Has Been Declined.";
            });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOneApproved(Auth $auth, $id)
    {
        $flight = FlightRpl::where('id', $id)->where('status_id', Status::APPROVED)
            ->where('operator_id', $auth->getId())
            ->with('flights.days')
            ->get();
        return $flight;
    }
}