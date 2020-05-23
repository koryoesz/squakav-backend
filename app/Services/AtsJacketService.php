<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/19/2020
 * Time: 10:23 AM
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;

class AtsJacketService
{
    /**
     * @param $params
     * @return bool
     */
    public static function createAtsFlightJacket($params, $flight_id)
    {
        $prepareParams = [
            'light' => isset($params['light']) ? $params['light']: '',
            'fluores' => isset($params['fluores']) ? $params['fluores']: '',
            'uhf' => isset($params['uhf']) ? $params['uhf']: '',
            'vhf' => isset($params['vhf']) ? $params['vhf']: '',
            'flight_id' => isset($flight_id) ? $flight_id : ''
        ];

        $validator = Validator::make($params, [
            'light' => 'required|bool',
            'fluores' => 'required|bool',
            'uhf' => 'required|bool',
            'vhf' => 'required|bool',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $jacket = DB::table('flight_ats_jackets')->insert($prepareParams);
    }
}