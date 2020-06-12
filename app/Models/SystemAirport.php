<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/12/2020
 * Time: 4:54 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemAirport extends Model
{
    protected $with = ['state'];

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }
}