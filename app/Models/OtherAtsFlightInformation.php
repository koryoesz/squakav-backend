<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/24/2020
 * Time: 11:56 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class OtherAtsFlightInformation extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'other_ats_flight_information_id', 'flight_id', 'value'
    ];
}