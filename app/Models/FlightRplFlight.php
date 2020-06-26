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
        'total_eet', 'time', 'remarks'];
}