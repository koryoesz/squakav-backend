<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:08 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;

class SystemFlightService
{
    /**
     * @param $params
     */
    public static function save($params)
    {
        $validator = Validator::make($params, [
            'flight_id' => 'numeric',
            'system_flight_types_id' => 'numeric',

        ]);
        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $system_flight = DB::table('system_flights')->insert($params);
    }
}