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

class FlightEquipmentService
{
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

}