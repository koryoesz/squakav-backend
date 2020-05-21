<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/24/2020
 * Time: 1:30 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightAtsTransponder extends Model
{
    protected $table = "flight_ats_transponder";

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'transponder_id', 'flight_id'
    ];
}