<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/1/2020
 * Time: 6:16 PM
 */

namespace App\Services;
use App\Models\EquipmentType;
use Illuminate\Support\Facades\Cache;

class FlightEquipmentTypeService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function getAllFlightEquipmentType()
    {
        $types = Cache::get('flight_equipment_types');

        if(empty($types))
        {
            $types = EquipmentType::all();
            Cache::put('flight_equipment_types', $types, 180000);
        }
        return $types;
    }
}