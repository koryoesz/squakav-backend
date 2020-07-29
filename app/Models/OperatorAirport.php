<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/29/2020
 * Time: 1:02 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatorAirport extends Model
{
    protected $table = "operator_airports";

    protected $hidden = ['id', 'operator_id'];

    public function system_airport()
    {
        return $this->hasOne('App\Models\SystemAirport', 'id', 'system_airport_id');
    }

}