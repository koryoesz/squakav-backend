<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtsFlightRule extends Model
{
    protected $table = "ats_flight_rules";

    protected $hidden = ['created_at', 'updated_at', ''];

}
