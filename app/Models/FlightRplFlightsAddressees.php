<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/9/2020
 * Time: 2:21 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightRplFlightsAddressees extends Model
{
    protected $table = "flight_rpl_flights_addressees";

    public function flight()
    {
        return $this->belongsTo('App\Models\FlightRplFlight', 'flight_id', 'id');
    }
}