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

class FlightAtsService
{
    // validate equipment/save
    // validate transponders/save
    // other information
    // emergency service
    // survival equipment
    // jackets
    // attachments
    public function create($params)
    {
//        $emergency = (new AtsEmergencyService())->createAtsFlightEmergency($params);
//        return $emergency;

        $validator = Validator::make($params, [
            'equipments' => 'required|array',
            'transponders' => 'required|array',
            'other_information' => 'required|array',
            'emergency' => 'required|array',
            'survival' => 'required|array',
            'jackets' => 'required|array',
            'aircraft_identification' => 'required|digits:7'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());
    }
}