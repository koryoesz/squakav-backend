<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/19/2020
 * Time: 10:14 AM
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;

class AtsSurvivalEquipmentService
{
    /**
     * @param $params
     * @return bool
     */
    public static function createAtsFlightSurvivalEquipment($params, $flight_id)
    {

        $prepareParams = [
            'polar' => isset($params['polar']) ? $params['polar']: '',
            'desert' => isset($params['desert']) ? $params['desert']: '',
            'maritime' => isset($params['maritime']) ? $params['maritime']: '',
            'jungle' => isset($params['jungle']) ? $params['jungle']: '',
            'flight_id' => isset($flight_id) ? $flight_id : ''
        ];

        $validator = Validator::make($params, [
            'polar' => 'required|bool',
            'desert' => 'required|bool',
            'maritime' => 'required|bool',
            'jungle' => 'required|bool',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $survival = DB::table('flight_ats_surviving_equipments')->insert($prepareParams);
    }
}