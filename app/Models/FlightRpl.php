<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/26/2020
 * Time: 3:40 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FlightRpl extends Model
{
    protected $table = "flight_rpl";

    protected $fillable = ['operator_id', 'valid_from', 'valid_till', 'departure_aerodrome',
        'supplementary_data', 'serial_number', 'accepted_date', 'accepted_by', 'status_id', 'additional_addressees'];

    public function flights()
    {
        return $this->hasMany('App\Models\FlightRplFlight', 'flight_rpl_id', 'id');
    }

    public function operator()
    {
        return $this->hasOne('App\Models\Operator', 'id', 'operator_id');
    }
}