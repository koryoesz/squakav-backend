<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/5/2020
 * Time: 10:31 AM
 */

namespace App\Services;

use App\Models\FlightAtsTransponder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;

class AtsTransponderService
{
    public function getFlightAtsTransponder()
    {
        $transponders = Cache::get('flight_ats_transponder');

        if(empty($transponders))
        {
            $transponders = FlightAtsTransponder::all();
            Cache::put('flight_ats_transponder', $transponders, 180000);
        }
        return $transponders;
    }

    /**
     * @param Array $paramsArray
     * @return bool
     */
    public static function createAtsTransponder($param, $flight_id)
    {
        $prepareParams = [];

        $prepareParams = [
            'transponder_id' => isset($param['transponder_id'])
                ? $param['transponder_id']: '',
            'flight_id' => isset($flight_id) ? $flight_id: '',
        ];

        $validator = Validator::make($prepareParams, [
            'transponder_id' => 'required|exists:transponders,id',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());


        $transponders = DB::table('flight_ats_transponder')->insert($prepareParams);
    }

    /**
     * @param $paramsArray
     * @return bool
     */
    public static function createAtsTransponderProperties($paramsArray, $flight_id)
    {
        $prepareParams = [];

        foreach ($paramsArray as $param)
        {
            $prepareParams[] = [
                'transponder_properties_id' => isset($param['transponder_properties_id'])
                    ? $param['transponder_properties_id']: '',
                'flight_id' => isset($flight_id) ? $flight_id: '',
            ];

            $validator = Validator::make($param, [
                'transponder_properties_id' => 'required|exists:transponder_type_properties,id',
            ]);

            throw_if($validator->fails(), ValidationException::class, $validator->errors());

        }

        $properties = DB::table('flight_ats_transponder_properties')->insert($prepareParams);
        return $properties;
    }
}