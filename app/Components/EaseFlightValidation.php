<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/10/2020
 * Time: 4:27 PM
 */

namespace App\Components;

use Illuminate\Support\Facades\Validator;

class EaseFlightValidation
{
    /**
     * @param $params
     */
    public static function validate($params)
    {
        $validator = Validator::make($params, [
            'aircraft_identification' => 'required|string|max:7',
//            'ats_flight_rules_id' => 'sometimes|numeric|exists:ats_flight_rules,id',
//            'aircraft_type' => 'sometimes|required|string|min:2|max:4',
//            'wake_turbulence_category_id' => 'sometimes|exists:wake_turbulence_category,id',
//            'departure' => 'sometimes|string|min:3|max:4',
//            'cruising_speed' => 'sometimes|string|min:4|max:5',
//            'level' => 'sometimes|string|min:4|max:5',
//            'route' => 'sometimes|string|max:128',
//            'destination' => 'sometimes|string|min:3|max:4',
//            'total_eet' => 'sometimes|numeric|digits:4',
//            'alternate_one' => 'sometimes|string|min:3|max:4',
//            'alternate_two' => 'sometimes|string|min:3|max:4',
//            'endurance' => 'sometimes|numeric|digits:4',
//            'persons_on_board' => 'sometimes|string|min:3|max:3',
//            'filed_by' => 'sometimes|string|max:128',
//            'color_markings' => 'sometimes|string|max:128',
//            'pilot_in_command' => 'sometimes|string|max:128',
//            'flight_type_id' => 'sometimes|numeric|exists:flight_types,id',
//            'time' => 'sometimes|digits:4',
//            'number' => 'sometimes|digits:2',
//            'remarks' => 'sometimes|required',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());
    }


    /**
     * @param $params
     */
    public static function forceValidate($params)
    {
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
    }

}