<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/26/2020
 * Time: 9:37 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightRplFlight extends Model
{
    protected $fillable = ['flight_rpl_id', 'aircraft_identification', 'aircraft_reg', 'aircraft_type',
        'wake_turbulence_category_id', 'cruising_speed', 'level', 'routes', 'destination',
        'total_eet', 'time', 'remarks', 'flight_rpl_days_id', 'destination_airport_id'];

    public function days()
    {
        return $this->hasOne('App\Models\FlightRplDay', 'id', 'flight_rpl_days_id');
    }

    public function addressees()
    {
        return $this->hasMany('App\Models\FlightRplFlightsAddressees', 'flight_id');
    }

    public function rplFlight()
    {
        return $this->belongsTo('App\Models\FlightRpl', 'flight_rpl_id', 'id');
    }
}