<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/26/2020
 * Time: 9:42 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Components\EaseFlightValidation;

class FlightRplFlightsService
{
    public static function createFlights($flights, $flight_id)
    {
        $prepareParams = self::prepareAndValidateFlights($flights, $flight_id);
        $properties = DB::table('flight_rpl_flights')->insert($prepareParams);
    }

    private static function prepareAndValidateFlights($paramsArray, $flight_id)
    {
        $prepareParams = [];

        foreach ($paramsArray as $param)
        {
            $param['flight_rpl_id'] = $flight_id;

            EaseFlightValidation::forceValidateRplFlights($param);

            $prepareParams[] = $param;

        }
        return $prepareParams;
    }
}