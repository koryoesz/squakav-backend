<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/19/2020
 * Time: 8:44 AM
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use App\Models\FlightAtsEmergency;

class AtsEmergencyService
{
    /**
     * @param $params
     * @return bool
     */
    public function createAtsFlightEmergency($params, $flight_id)
    {
        $prepareParams = [
            'uhf' => isset($params['uhf']) ? $params['uhf']: '',
            'vhf' => isset($params['vhf']) ? $params['vhf']: '',
            'elt' => isset($params['elt']) ? $params['elt']: '',
            'flight_id' => isset($flight_id) ? $flight_id : ''
        ];

        $validator = Validator::make($params, [
            'uhf' => 'required|numeric|bool',
            'vhf' => 'required|numeric|bool',
            'elt' => 'required|numeric|bool',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $emergency = FlightAtsEmergency::create($prepareParams);
        return $emergency;
    }
}