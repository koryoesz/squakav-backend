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
use App\Models\FlightAtsSurvivingEquipment;

class AtsSurvivalEquipmentService
{
    /**
     * @param $params
     * @return bool
     */
    public static function createAtsFlightSurvivalEquipment($params, $flight_id)
    {
        $prepareParams = self::prepareAndValidateAtsFlightSurvivalEquipment($params, $flight_id);
        $survival = DB::table('flight_ats_surviving_equipments')->insert($prepareParams);
    }

    /**
     * @param $params
     * @param $flight_id
     * @return bool
     */
    public static function updateAtsFlightSurvivalEquipment($params, $flight_id)
    {
        $prepareParams = self::prepareAndValidateAtsFlightSurvivalEquipment($params, $flight_id);

        $survival = FlightAtsSurvivingEquipment::where('flight_id', $flight_id)->get();
        if($survival->count() == 0)
        {
            return DB::table('flight_ats_surviving_equipments')->insert($prepareParams);
        }

        $survival[0]->update($prepareParams);
    }

    protected static function prepareAndValidateAtsFlightSurvivalEquipment($params, $flight_id)
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

        return $prepareParams;
    }
}