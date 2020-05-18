<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:08 PM
 */

namespace App\Services;

use App\Models\SystemFlight;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;

class SystemFlightService
{
    /**
     * @param $params
     */
    public function save($params)
    {
        $validator = Validator::make($params, [
            'flight_id' => 'numeric',
            'system_flight_types_id' => 'numeric',

        ]);
        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $flight = SystemFlight::create([
           'flight_id' => 1,
            'system_flight_types_id'
        ]);

        return $flight;
    }
}