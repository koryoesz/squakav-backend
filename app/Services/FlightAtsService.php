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
    public function create($params)
    {
        return $this->createFlightPlan($params);
    }

    /**
 * Draft Ats Flight Plan
 */
    public function draft($params)
    {
        $params['status_id'] = Status::DRAFTED;
        return $this->draftFlightPlan($params);
    }

    /**
     * @param $id
     * @return mixed
     * Return single drafted flight
     */
    public function getOneDraft($id)
    {
        $flight = FlightAts::where('id', $id)->where('status_id', Status::DRAFTED)->first();
        return $flight;
    }
    /**
     * @param $params
     * @return mixed
     * @throws MyException
     */
    private function createFlightPlan($params)
    {
        $equipments = null;
        $emergency = null;

        if (empty($this->system_flight)){
            throw new MyException('Could not find system config', ErrorCode::INTERNAL_ERROR);
        }

        $validator = Validator::make($params, [
            'aircraft_identification' => 'required|string|max:7',
            'ats_flight_rules_id' => 'required|numeric|exists:ats_flight_rules,id',
            'aircraft_type' => 'sometimes|required|string|min:2|max:4',
            'wake_turbulence_category_id' => 'exists:wake_turbulence_category,id',
            'departure' => 'required|string|min:3|max:4',
            'cruising_speed' => 'required|string|min:4|max:5',
            'level' => 'required|string|min:4|max:5',
            'route' => 'required|string|max:128',
            'destination' => 'required|string|min:3|max:4',
            'total_eet' => 'required|numeric|digits:4',
            'alternate_one' => 'required|string|min:3|max:4',
            'alternate_two' => 'sometimes|required|string|min:3|max:4',
            'endurance' => 'required|numeric|digits:4',
            'persons_on_board' => 'required|string|min:3|max:3',
            'filed_by' => 'required|string|max:128',
            'color_markings' => 'required|string|max:128',
            'pilot_in_command' => 'required|string|max:128',
            'flight_type_id' => 'required|numeric|exists:flight_types,id',
            'time' => 'required|digits:4',
            'number' => 'sometimes|digits:2',
            'remarks' => 'sometimes|required',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($params){
            // create flight
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

            (new SystemFlightService())::save($system_flight_params);

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
    private function draftFlightPlan($params)
    {
        $equipments = null;
        $emergency = null;

        if (empty($this->system_flight)){
            throw new MyException('Could not find system config', ErrorCode::INTERNAL_ERROR);
        }

        $validator = Validator::make($params, [
            'aircraft_identification' => 'required|string|max:7',
            'ats_flight_rules_id' => 'sometimes|numeric|exists:ats_flight_rules,id',
            'aircraft_type' => 'sometimes|required|string|min:2|max:4',
            'wake_turbulence_category_id' => 'sometimes|exists:wake_turbulence_category,id',
            'departure' => 'sometimes|string|min:3|max:4',
            'cruising_speed' => 'sometimes|string|min:4|max:5',
            'level' => 'sometimes|string|min:4|max:5',
            'route' => 'sometimes|string|max:128',
            'destination' => 'sometimes|string|min:3|max:4',
            'total_eet' => 'sometimes|numeric|digits:4',
            'alternate_one' => 'sometimes|string|min:3|max:4',
            'alternate_two' => 'sometimes|string|min:3|max:4',
            'endurance' => 'sometimes|numeric|digits:4',
            'persons_on_board' => 'sometimes|string|min:3|max:3',
            'filed_by' => 'sometimes|string|max:128',
            'color_markings' => 'sometimes|string|max:128',
            'pilot_in_command' => 'sometimes|string|max:128',
            'flight_type_id' => 'sometimes|numeric|exists:flight_types,id',
            'time' => 'sometimes|digits:4',
            'number' => 'sometimes|digits:2',
            'remarks' => 'sometimes|required',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($params){
                // create flight
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

                (new SystemFlightService())::save($system_flight_params);

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
    public function getAllSent()
    {
        $flights = FlightAts::where('status_id', Status::ACTIVE)
                    ->orderBy('created_at', 'desc')->get();
        return $flights;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOneSent($id)
    {
        $flight = FlightAts::where('id', $id)->where('status_id', Status::ACTIVE)->first();
        return $flight;
    }

    /**
     * @param $user_id
     * @param $user_type_id
     * @param $params
     * @return string
     */
    public function approve($user_id, $params)
    {
        // include routes
        $extra_param = ['user_id' => $user_id,
                        'remarks' => isset($params['remarks']) ? $params['remarks']: '',
                        'flight_id' => isset($params['flight_id']) ? $params['flight_id']: ''
                        ];

        $validator = Validator::make($extra_param, [
            'user_id' => [
                'numeric',
                Rule::exists('ais_users', 'id')
                ->where('user_type_id', UserType::AIS_USER_TYPE_ID)
                ],
            'remarks' => 'required',
            'flight_id' => [
                    'required',
                    'numeric',
                    Rule::exists('system_flights', 'flight_id')
                        ->where('system_flight_types_id', SystemFightType::ATS)
                    ]
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

        $system_flight[0]->status_id = Status::APPROVED;
        $flight->status_id = Status::APPROVED;

        $system_flight[0]->save();
        $flight->save();

        return "ATS Flight Plan Has Been Approved.";
    }

    /**
     * @return mixed
     */
    public function approvedFlights()
    {
        $flights = FlightAts::where('status_id', Status::APPROVED)->get();
        return $flights;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getOneApproved($id)
    {
        $flight = FlightAts::where('id', $id)->where('status_id', Status::APPROVED)->get();
        return $flight;
    }

    /**
     * @param $user_id
     * @param $params
     * @return string
     * @throws MyException
     */
    public function decline($user_id, $params)
    {
        $extra_param = ['user_id' => $user_id,
            'remarks' => isset($params['remarks']) ? $params['remarks']: '',
            'flight_id' => isset($params['flight_id']) ? $params['flight_id']: ''
        ];

        $validator = Validator::make($extra_param, [
            'user_id' => [
                'numeric',
                Rule::exists('ais_users', 'id')
                    ->where('user_type_id', UserType::AIS_USER_TYPE_ID)
            ],
            'additional_requirement' => 'required',
            'flight_id' => [
                'required',
                'numeric',
                Rule::exists('system_flights', 'flight_id')
                    ->where('system_flight_types_id', SystemFightType::ATS)
            ]
        ], [
            'user_id.exists' => 'User not authorized to approve ATS flight',
            'flight_id.exists' => 'Invalid Flight'
        ]);

        // validator
        // fails
        // where is it ???/??????

        $flight = FlightAts::find($params['flight_id']);
        $system_flight = SystemFlight::where('flight_id', $params['flight_id'])->get();

        if(empty($flight) && empty($system_flight)){
            throw (new MyException('Flight record not found', ErrorCode::RECORD_NOT_EXISTING));
        }

        $system_flight[0]->status_id = Status::DECLINED;
        $flight->status_id = Status::DECLINED;

        $system_flight[0]->save();
        $flight->save();

        return "ATS Flight Plan Has Been Declined.";
    }

}