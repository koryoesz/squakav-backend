<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/30/2020
 * Time: 9:41 AM
 */

namespace App\Services;

use App\Models\FlightType;
use Illuminate\Support\Facades\Cache;

class FlightTypeService
{
    public function getAllFlightType()
    {
        $types = Cache::get('flight_types');

        if(empty($types))
        {
            $types = FlightType::all();
            Cache::put('flight_types', $types, 18000);
        }

        return $types;
    }
}