<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/1/2020
 * Time: 5:19 PM
 */

namespace App\Services;

use App\Models\Equipment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;

class FlightEquipmentService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function getAllFlightEquipment()
    {
        $equipments = Cache::get('flight_equipments');

        if(empty($equipments))
        {
            $equipments = Equipment::all();
            Cache::put('flight_equipments', $equipments, 180000);
        }
        return $equipments;
    }

    public function createAtsEquipment($paramsArray, $flight_id)
    {
        $prepareParams = $this->prepareAndValidateAtsEquipment($paramsArray, $flight_id);
        $equipments = DB::table('flight_ats_equipments')->insert($prepareParams);
        return $equipments;
    }

    public function updateAtsEquipment($paramsArray, $flight_id)
    {
        $prepareParams = $this->prepareAndValidateAtsEquipment($paramsArray, $flight_id);

        $equipments = Equipment::where('flight_id', $flight_id)->get();

        if($equipments->count() == 0)
        {
            return DB::table('flight_ats_equipments')->insert($prepareParams);
        }

        foreach ($equipments as $equipment)
        {
            $equipment->delete();
        }

        return DB::table('flight_ats_equipments')->insert($prepareParams);

    }

    protected function prepareAndValidateAtsEquipment($paramsArray, $flight_id)
    {
        $prepareParams = [];
        foreach ($paramsArray as $param)
        {
            $prepareParams[] = [
                'flight_equipment_id' => isset($param['flight_equipment_id']) ? $param['flight_equipment_id']: '',
                'flight_id' => isset($flight_id) ? $flight_id: '',
            ];

            $validator = Validator::make($param, [
                'flight_equipment_id' => 'required|exists:equipments,id',
            ]);

            throw_if($validator->fails(), ValidationException::class, $validator->errors());

        }

        return $prepareParams;
    }

}