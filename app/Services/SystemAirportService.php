<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/12/2020
 * Time: 4:30 PM
 */

namespace App\Services;

use App\Models\SystemAirport;
use Illuminate\Support\Facades\Cache;

class SystemAirportService
{
    public function getAll()
    {
        $system_airports = Cache::get('system_airports');

        if(empty($system_airports))
        {
            $system_airports = SystemAirport::all();
            Cache::put('system_airports', $system_airports, 180000);
        }

        return $system_airports;
    }
}