<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/5/2020
 * Time: 10:31 AM
 */

namespace App\Services;

use App\Models\Transponder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\FlightAtsTransponder;
use App\Models\FlightAtsTransponderProperties;

class AtsTransponderService
{
    public function getFlightAtsTransponder()
    {
        $transponders = Cache::get('flight_ats_transponder');

        if(empty($transponders))
        {
            $transponders = Transponder::all();
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
        $prepareParams = self::prepareAndValidateTransponder($param, $flight_id);
        $transponders = DB::table('flight_ats_transponder')->insert($prepareParams);
    }

    /**
     * @param $paramsArray
     * @return bool
     */
    public static function createAtsTransponderProperties($paramsArray, $flight_id)
    {
        $prepareParams = self::prepareAndValidateTransponderProperties($paramsArray, $flight_id);
        $properties = DB::table('flight_ats_transponder_properties')->insert($prepareParams);
    }

    public static function updateAtsTransponder($param, $flight_id)
    {
        $prepareParams = self::prepareAndValidateTransponder($param, $flight_id);

        $transponder = FlightAtsTransponder::where('flight_id', $flight_id);

        if($transponder->count() == 0)
        {
            return DB::table('flight_ats_transponder')->insert($prepareParams);
        }

        $transponder->update($prepareParams);
    }

    public static function updateAtsTransponderProperties($paramsArray, $flight_id)
    {
        $prepareParams = self::prepareAndValidateTransponderProperties($paramsArray, $flight_id);

        $properties = FlightAtsTransponderProperties::where('flight_id', $flight_id)->get();

        if($properties->count() == 0)
        {
            return DB::table('flight_ats_transponder_properties')->insert($prepareParams);
        }

        foreach ($properties as $property)
        {
            $property->delete();
        }

        DB::table('flight_ats_transponder_properties')->insert($prepareParams);

    }

    /**
     * @param $param
     * @param $flight_id
     * @return array
     */
    protected static function prepareAndValidateTransponder($param, $flight_id)
    {
        $prepareParams = [
            'transponder_id' => isset($param['transponder_id'])
                ? $param['transponder_id']: '',
            'flight_id' => isset($flight_id) ? $flight_id: '',
        ];

        $validator = Validator::make($prepareParams, [
            'transponder_id' => 'required|exists:transponders,id',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        return $prepareParams;
    }

    /**
     * @param $paramsArray
     * @param $flight_id
     * @return array
     */
    protected static function prepareAndValidateTransponderProperties($paramsArray, $flight_id)
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
        return $prepareParams;
    }
}