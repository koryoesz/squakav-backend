<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/10/2020
 * Time: 5:19 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;

class FlightRplAddresseesService
{
    public static function saveAddressees($paramsArray)
    {
        $prepareParams = self::prepareAndValidateAddressees($paramsArray);
        $properties = DB::table('flight_rpl_flights_addressees')->insert($prepareParams);
    }

    /**
     * @param $paramsArray
     * @param $flight_id
     * @return array
     */
    protected static function prepareAndValidateAddressees($paramsArray)
    {
        $prepareParams = [];

        foreach ($paramsArray as $param)
        {
            $prepareParams[] = [
                'system_airport_id' => isset($param['system_airport_id'])
                    ? $param['system_airport_id']: '',
                'flight_id' => isset($param['flight_id']) ? $param['flight_id']: '',
            ];

            $validator = Validator::make($param, [
                'system_airport_id' => 'required|exists:system_airports,id',
                'flight_id' => 'required|exists:flight_rpl_flights,id'
            ]);

            throw_if($validator->fails(), ValidationException::class, $validator->errors());

        }
        return $prepareParams;
    }
}