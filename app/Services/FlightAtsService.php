<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 11:39 PM
 */

namespace App\Services;

use App\Models\FlightAts;
use App\Models\SystemFlight;
use App\Models\Status;
use App\Models\UserType;
use App\Models\SystemFightType;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Components\Exception as MyException;
use App\Components\ErrorCode;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule;
use App\Components\EaseFlightValidation;
use App\Components\Auth;
use App\Services\FlightAtsAddresseesService;

class FlightAtsService
{

    protected $system_flight;

    public function __construct()
    {
        $this->system_flight = Config::get('constant_system_flight_type');
    }

    /**
     * Create Ats flight Plan
     */
    public function create($params, Auth $auth)
    {
        return $this->createFlightPlan($params, $auth);
    }

    /**
 * Draft Ats Flight Plan
 */
    public function draft($params, Auth $auth)
    {
        $params['status_id'] = Status::DRAFTED;
        return $this->draftFlightPlan($params,  $auth);
    }

    /**
     * @param $id
     * @return mixed
     * Return single drafted flight
     */
    public function getOneDraft(Auth $auth, $id)
    {
        $flight = FlightAts::where('id', $id)
            ->where('status_id', Status::DRAFTED)
            ->where('operator_id', $auth->getId())
            ->first();
        return $flight;
    }

    /**
     * @param $params
     * @param Auth $auth
     * @return mixed
     * @throws MyException
     */
    private function createFlightPlan($params, Auth $auth)
    {
        $equipments = null;
        $emergency = null;

        if (empty($this->system_flight)){
            throw new MyException('Could not find system config', ErrorCode::INTERNAL_ERROR);
        }

        EaseFlightValidation::forceValidate($params);

        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($params, $auth){
            // create flight

            $params['operator_id'] = $auth->getId();
            $flight = FlightAts::create($params);

            if(empty($flight)){
                throw (new MyException('Create Flight Record Failed', ErrorCode::INTERNAL_ERROR));
            }

            // store for system flight
            // build params for system flight ats
            $system_flight_params = [
                'flight_id' => $flight->id,
                'system_flight_types_id' => $this->system_flight['ats']['id'],
                'status_id' => isset($params['status_id']) ? $params['status_id'] : 1
            ];

            (new SystemFlightService())::save($system_flight_params, $auth);

            if(isset($params['equipments']))
            {
                $equipments = (new FlightEquipmentService())
                    ->createAtsEquipment($params['equipments'], $flight->id);
            }
            if(isset($params['transponder']))
            {
                (new AtsTransponderService())
                    ::createAtsTransponder($params['transponder'], $flight->id);
            }

            if(isset($params['transponder_properties']))
            {
                (new AtsTransponderService())
                    ::createAtsTransponderProperties($params['transponder_properties'], $flight->id);
            }

            if(isset($params['other_information']))
            {
                (new OtherAtsFlightInformationService())
                    ::createAtsFlightOtherInformation($params['other_information'], $flight->id);
            }

            if(isset($params['emergency']))
            {
                $emergency = (new AtsEmergencyService())
                    ->createAtsFlightEmergency($params['emergency'], $flight->id);
            }

            if(isset($params['survival_equipment']))
            {
                (new AtsSurvivalEquipmentService())
                    ::createAtsFlightSurvivalEquipment($params['survival_equipment'], $flight->id);
            }

            if(isset($params['jackets']))
            {
                (new AtsJacketService())
                    ::createAtsFlightJacket($params['jackets'], $flight->id);
            }

            if(isset($params['dinghies']))
            {
                (new FlightAtsDinghiesService())
                    ::createAtsDinghies($params['dinghies'], $flight->id);
            }

            return $flight;
        });

    }

    /**
     * @param $params
     * @return mixed
     * @throws MyException
     */
    private function draftFlightPlan($params, Auth $auth)
    {
        $equipments = null;
        $emergency = null;

        if (empty($this->system_flight)){
            throw new MyException('Could not find system config', ErrorCode::INTERNAL_ERROR);
        }

        EaseFlightValidation::validate($params);

        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($params, $auth){
                // create flight
                $params['operator_id'] = $auth->getId();
                $flight = FlightAts::create($params);

                if(empty($flight)){
                    throw (new MyException('Create Flight Record Failed', ErrorCode::INTERNAL_ERROR));
                }

                // store for system flight
                // build params for system flight ats
                $system_flight_params = [
                    'flight_id' => $flight->id,
                    'system_flight_types_id' => $this->system_flight['ats']['id'],
                    'status_id' => isset($params['status_id']) ? $params['status_id'] : Status::DRAFTED
                ];

                (new SystemFlightService())::save($system_flight_params, $auth);

                if(isset($params['equipments']))
                {
                    $equipments = (new FlightEquipmentService())
                        ->createAtsEquipment($params['equipments'], $flight->id);
                }
                if(isset($params['transponder']))
                {
                    (new AtsTransponderService())
                        ::createAtsTransponder($params['transponder'], $flight->id);
                }

                if(isset($params['transponder_properties']))
                {
                    (new AtsTransponderService())
                        ::createAtsTransponderProperties($params['transponder_properties'], $flight->id);
                }

                if(isset($params['other_information']))
                {
                    (new OtherAtsFlightInformationService())
                        ::createAtsFlightOtherInformation($params['other_information'], $flight->id);
                }

                if(isset($params['emergency']))
                {
                    $emergency = (new AtsEmergencyService())
                        ->createAtsFlightEmergency($params['emergency'], $flight->id);
                }

                if(isset($params['survival_equipment']))
                {
                    (new AtsSurvivalEquipmentService())
                        ::createAtsFlightSurvivalEquipment($params['survival_equipment'], $flight->id);
                }

                if(isset($params['jackets']))
                {
                    (new AtsJacketService())
                        ::createAtsFlightJacket($params['jackets'], $flight->id);
                }

                if(isset($params['dinghies']))
                {
                    (new FlightAtsDinghiesService())
                        ::createAtsDinghies($params['dinghies'], $flight->id);
                }

                return $flight;
            });

    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllSent(Auth $auth)
    {
        $flights = FlightAts::where('status_id', Status::ACTIVE)
                    ->where('operator_id', $auth->getId())
                    ->orderBy('created_at', 'desc')->get();
        return $flights;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOneSent(Auth $auth, $id)
    {
        if($auth->getType() == UserType::TYPE_AIS)
        {
            $flight = FlightAts::where('id', $id)
                ->where('status_id', Status::ACTIVE)
                ->first();
            return $flight;
        }
        $flight = FlightAts::where('id', $id)
            ->where(function($query){
                $query->where('status_id', Status::ACTIVE)
                    ->orWhere('status_id', Status::DECLINED);
            })->where('operator_id', $auth->getId())
            ->first();
        return $flight;
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
                        ->where('system_flight_types_id', SystemFightType::ATS)
                        ->where('status_id', Status::ACTIVE)
                    ],
            'addressees' => 'sometimes|array'
        ], [
            'user_id.exists' => 'User not authorized to approve ATS flight',
            'flight_id.exists' => 'Invalid Flight'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $flight = FlightAts::find($params['flight_id']);
        $system_flight = SystemFlight::where('flight_id', $params['flight_id'])->get();

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
                        (new FlightAtsAddresseesService())::saveAddressees($params['addressees'], $flight->id);
                    }

                    return ['aircraft_identification' => $flight->aircraft_identification];
                });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOneApproved(Auth $auth, $id)
    {
        $flight = FlightAts::where('id', $id)->where('status_id', Status::APPROVED)
            ->where('operator_id', $auth->getId())
            ->get();
        return $flight;
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
                    ->where('system_flight_types_id', SystemFightType::ATS)
                    ->where('status_id', Status::ACTIVE)
            ],
            'official_remarks' => 'required'
        ], [
            'user_id.exists' => 'User not authorized to approve ATS flight',
            'flight_id.exists' => 'Invalid Flight'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $flight = FlightAts::find($params['flight_id']);
        $system_flight = SystemFlight::where('flight_id', $params['flight_id'])->get();

        if(empty($flight) && empty($system_flight)){
            throw (new MyException('Flight record not found', ErrorCode::RECORD_NOT_EXISTING));
        }

        $system_flight[0]->status_id = Status::DECLINED;
        $flight->status_id = Status::DECLINED;
        $flight->official_remarks = $params['official_remarks'];

        $system_flight[0]->save();
        $flight->save();

        return $flight->aircraft_identification." ATS Flight Plan Has Been Declined.";
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

        $validator = Validator::make(['flight_id' => $flight_id], [
            'flight_id' => [
                'required',
                'numeric',
                Rule::exists('flight_ats', 'id')
                    ->where(function($query){
                        $query->where('status_id', Status::ACTIVE)
                            ->orWhere('status_id', Status::DECLINED);
                    })->where('operator_id', $auth->getId())
            ]
        ],[
            'flight_id.exists' => 'This flight may not exist or it has been approved.'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        if(isset($params['send']) && $params['send'] == '1'){

            EaseFlightValidation::forceValidate($params);

            $params['status_id'] = Status::ACTIVE;
            $flight = FlightAts::find($flight_id);
            $system_flight = SystemFlight::where('flight_id', $flight_id)
                ->where('system_flight_types_id',$this->system_flight['ats']['id'])
                ->get();
            $system_flight[0]->status_id = Status::ACTIVE;
            $system_flight[0]->save();
            $flight->update($params);
        } else{
            
            EaseFlightValidation::validate($params);

            $flight = FlightAts::find($flight_id);
            $flight->update($params);
        }


        if(isset($params['equipments']))
        {
            $equipments = (new FlightEquipmentService())
                ->updateAtsEquipment($params['equipments'], $flight->id);
        }
        if(isset($params['transponder']))
        {
            (new AtsTransponderService())::updateAtsTransponder($params['transponder'], $flight->id);

        }

        if(isset($params['transponder_properties']))
        {
            (new AtsTransponderService())::updateAtsTransponderProperties($params['transponder_properties'], $flight->id);
        }

        if(isset($params['other_information']))
        {
            (new OtherAtsFlightInformationService())
                ::updateAtsFlightOtherInformation($params['other_information'], $flight->id);
        }

        if(isset($params['emergency']))
        {
            $emergency = (new AtsEmergencyService())->updateAtsFlightEmergency($params['emergency'], $flight->id);
        }

        if(isset($params['survival_equipment']))
        {
            (new AtsSurvivalEquipmentService())
                ::updateAtsFlightSurvivalEquipment($params['survival_equipment'], $flight->id);
        }

        if(isset($params['jackets']))
        {
            (new AtsJacketService())::updateAtsFlightJacket($params['jackets'], $flight->id);
        }

        if(isset($params['dinghies']))
        {
            (new FlightAtsDinghiesService())::updateAtsDinghies($params['dinghies'], $flight->id);
        }

        return $flight->refresh();
    }

    public function getAllApproved(Auth $auth)
    {
        if($auth->getType() == UserType::TYPE_AIS)
        {
            $flight = FlightAts::where('status_id', Status::APPROVED)
                ->orderBy('created_at', 'desc')->get();
            return $flight;
        }

        $flights = FlightAts::where('status_id', Status::APPROVED)
            ->where('operator_id', $auth->getId())
            ->orderBy('created_at', 'desc')->get();
        return $flights;
    }
}