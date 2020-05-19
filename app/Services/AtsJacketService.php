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
    public function createAtsFlightJacket($params)
    {
        $validator = Validator::make($params, [
            'light' => 'required|numeric|bool',
            'fluores' => 'required|numeric|bool',
            'uhf' => 'required|numeric|bool',
            'vhf' => 'required|numeric|bool',
            'flight_id' => 'required|exists:flight_ats,id'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $jacket = DB::table('flight_ats_jackets')->insert($params);
        return $jacket;
    }
}