<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/20/2020
 * Time: 1:19 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightAtsEmergency extends Model
{
    protected $table = "flight_ats_emergency";

    protected $fillable = [
      'uhf', 'vhf', 'elt', 'flight_id'
    ];
}