<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/26/2020
 * Time: 11:59 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightRplDay extends Model
{
    public $table = "flight_rpl_days";

    public $fillable = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday',
        'sunday'];
}