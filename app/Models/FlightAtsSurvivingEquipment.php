<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/24/2020
 * Time: 1:35 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightAtsSurvivingEquipment extends Model
{
    protected $table = "flight_ats_surviving_equipments";

    protected $fillable = [
        'polar', 'desert', 'maritime', 'jungle', 'flight_id'
    ];
}