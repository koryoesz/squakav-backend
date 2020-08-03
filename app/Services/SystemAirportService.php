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
use App\Components\Auth;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;

class SystemAirportService
{
    public function getAll(Auth $auth)
    {
        $system_airports = null;
        if($auth->getType() == UserType::TYPE_OPERATOR){
            $system_airports = Cache::get('system_airports_operator');
        } else{
            $system_airports = Cache::get('system_airports');
        }

        if(empty($system_airports))
        {
            if($auth->getType() == UserType::TYPE_OPERATOR){
                $system_airports = DB::table('system_airports')->select(['id', 'icao_code'])->get();
                Cache::put('system_airports_operator', $system_airports, 180000);
            } else{
                $system_airports = SystemAirport::all();
                Cache::put('system_airports', $system_airports, 180000);
            }

        }

        return $system_airports;
    }
}