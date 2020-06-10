<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/21/2020
 * Time: 7:39 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightAtsTransponderProperties extends Model
{
    protected $table = "flight_ats_transponder_properties";

    protected $hidden = ["id"];
}