<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/23/2020
 * Time: 12:04 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;

class FlightAtsAddresseesService
{

    public static function saveAddressees($paramsArray, $flight_id)
    {
        $prepareParams = self::prepareAndValidateAddressees($paramsArray, $flight_id);
        $properties = DB::table('flight_ats_addressees')->insert($prepareParams);
    }

    /**
     * @param $paramsArray
     * @param $flight_id
     * @return array
     */
    protected static function prepareAndValidateAddressees($paramsArray, $flight_id)
    {
        $prepareParams = [];

        foreach ($paramsArray as $param)
        {
            $prepareParams[] = [
                'system_airport_id' => isset($param['system_airport_id'])
                    ? $param['system_airport_id']: '',
                'flight_id' => isset($flight_id) ? $flight_id: '',
            ];

            $validator = Validator::make($param, [
                'system_airport_id' => 'required|exists:system_airports,id',
            ]);

            throw_if($validator->fails(), ValidationException::class, $validator->errors());

        }
        return $prepareParams;
    }
}