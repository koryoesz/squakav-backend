<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/21/2020
 * Time: 8:05 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightAtsOtherFlightInformation extends Model
{
    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function relation()
    {
        return $this->belongsTo('App\Models\OtherAtsFlightInformation',
            'other_ats_flight_information_id', 'id');
    }
}