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
use Illuminate\Support\Facades\DB;

class AtsEmergencyService
{
    /**
     * @param $params
     * @return bool
     */
    public function createAtsFlightEmergency($params)
    {
//        $prepareParams = [
//            'uhf' => isset($params['uhf']) ? $params['uhf']: '',
//            'vhf' => isset($params['vhf']) ? $params['vhf']: '',
//            'elt' => isset($params['elt']) ? $params['elt']: '',
//            'flight_id' => isset($params['flight_id']) ? $params['flight_id']: ''
//        ];

        $validator = Validator::make($params, [
            'uhf' => 'required|numeric|bool',
            'vhf' => 'required|numeric|bool',
            'elt' => 'required|numeric|bool',
            'flight_id' => 'required|exists:flight_ats,id'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $emergency = DB::table('flight_ats_emergency')->insert($params);
        return $emergency;
    }
}