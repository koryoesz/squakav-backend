<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/21/2020
 * Time: 1:37 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightAtsEquipment extends Model
{
    protected $table = "flight_ats_equipments";

    protected $fillable = ['flight_equipment_id', 'flight_id'];

}