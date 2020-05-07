<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/5/2020
 * Time: 10:31 AM
 */

namespace App\Services;

use App\Models\FlightAtsTransponder;
use Illuminate\Support\Facades\Cache;

class AtsTransponderService
{
    public function getFlightAtsTransponder()
    {
        $transponders = Cache::get('flight_ats_transponder');

        if(empty($transponders))
        {
            $transponders = FlightAtsTransponder::all();
            Cache::put('flight_ats_transponder', $transponders, 180000);
        }
        return $transponders;
    }
}