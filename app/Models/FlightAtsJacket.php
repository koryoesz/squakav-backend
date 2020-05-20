<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/24/2020
 * Time: 1:33 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightAtsJacket extends Model
{
    protected $fillable = [
      'light', 'fluores', 'uhf', 'vhf', 'flight_id'
    ];
}