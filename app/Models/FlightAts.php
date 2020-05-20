<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/24/2020
 * Time: 1:20 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightAts extends Model
{
  protected $fillable = [
      'aircraft_identification', 'ats_flight_rules_id', 'aircraft_type', 'wake_turbulence_category_id',
      'departure', 'cruising_speed', 'level', 'route', 'destination', 'eet', 'alternate-one',
      'alternate-two', 'endurance', 'persons_on_board', 'filed_by', 'additional_requirement', 'number',
      'capacity', 'status_id', 'remarks', 'pilot_in_command', 'color_markings',
  ];
}