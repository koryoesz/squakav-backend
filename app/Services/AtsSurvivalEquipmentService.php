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
    public function createAtsFlightSurvivalEquipment($params)
    {

        $validator = Validator::make($params, [
            'polar' => 'required|numeric|bool',
            'desert' => 'required|numeric|bool',
            'maritime' => 'required|numeric|bool',
            'jungle' => 'required|numeric|bool',
            'flight_id' => 'required|exists:flight_ats,id'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $survival = DB::table('flight_ats_surviving_equipments')->insert($params);
        return $survival;
    }
}