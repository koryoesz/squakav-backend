<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 11:39 PM
 */

namespace App\Services;

use App\Models\FlightAts;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Components\Exception as MyException;
use App\Components\ErrorCode;
use Illuminate\Support\Facades\Config;

class FlightAtsService
{

    protected $system_flight;

    public function __construct()
    {
        $this->system_flight = Config::get('constant_system_flight_type');
    }

    /**
     * @param $params
     * @return mixed
     * @throws MyException
     */
    public function create($params)
    {
        $equipments = null;
        $emergency = null;

        if (empty($this->system_flight)){
            throw new MyException('Could not find system config', ErrorCode::INTERNAL_ERROR);
        }

        $validator = Validator::make($params, [
            'equipments' => 'required|array',
            'transponder' => 'required',
            'other_information' => 'required|array',
            'aircraft_identification' => 'required|string|min:7|max:7',
            'ats_flight_rules_id' => 'required|numeric|exists:ats_flight_rules,id',
            'aircraft_type' => 'required|string|min:4|max:4',
            'wake_turbulence_category_id' => 'exists:wake_turbulence_category,id',
            'departure' => 'required|string|min:4|max:4',
            'cruising_speed' => 'required|string|min:5|max:5',
            'level' => 'required|string|min:5|max:5',
            'route' => 'required|string|max:128',
            'destination' => 'required|string|min:4|max:4',
            'eet' => 'required|numeric|digits:4',
            'alternate_one' => 'required|string|min:4|max:4',
            'endurance' => 'required|numeric|digits:4',
            'persons_on_board' => 'required|numeric',
            'filed_by' => 'required|string|max:128',
            'color_markings' => 'required|string|max:128',
            'pilot_in_command' => 'required|string|max:128',
            'flight_type_id' => 'required|numeric|exists:flight_types,id'
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
                'system_flight_types_id' => $this->system_flight['ats']['id']
            ];

            (new SystemFlightService())::save($system_flight_params);

            $equipments = (new FlightEquipmentService())
                ->createAtsEquipment($params['equipments'], $flight->id);

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

            return $flight;
        });

    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllSent()
    {
        $sent_flights = FlightAts::all();
        return $sent_flights;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        $flight = FlightAts::find($id);
        return $flight;
    }

    /**
     * @param $user_id
     * @param $user_type_id
     */
    public function approve($user_id, $user_type_id)
    {

    }

}