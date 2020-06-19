<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:03 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SystemFlight extends Model
{
    protected $fillable = ['flight_id', 'system_flight_types_id', 'operator_id'];

    public $timestamps =  false;

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("Y-m-d H:m");
    }

}