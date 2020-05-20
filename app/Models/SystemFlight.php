<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:03 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemFlight extends Model
{

    protected $fillable = ['flight_id', 'system_flight_types_id'];
}