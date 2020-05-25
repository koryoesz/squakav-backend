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

  protected $with = ['equipments', 'transponders', 'transponderProperties',
      'otherInformation', 'emergency', 'survivalEquipment', 'jackets'];

  protected $fillable = [
      'aircraft_identification', 'ats_flight_rules_id', 'aircraft_type', 'wake_turbulence_category_id',
      'departure', 'cruising_speed', 'level', 'route', 'destination', 'eet', 'alternate-one',
      'alternate-two', 'endurance', 'persons_on_board', 'filed_by', 'additional_requirement', 'number',
      'capacity', 'status_id', 'remarks', 'pilot_in_command', 'color_markings', 'flight_type_id', 'flight_type_id',
      'alternate_one', 'alternate_two'
  ];

  public function equipments()
  {
      return $this->hasMany('App\Models\FlightAtsEquipment', 'flight_id');
  }

  public function transponders()
  {
      return $this->hasMany('App\Models\FlightAtsTransponder', 'flight_id');
  }

   public function transponderProperties()
   {
       return $this->hasMany('App\Models\FlightAtsTransponderProperties', 'flight_id');
   }

   public function otherInformation()
   {
       return $this->hasMany('App\Models\FlightAtsOtherFlightInformation', 'flight_id');
   }

    public function emergency()
    {
        return $this->hasMany('App\Models\FlightAtsEmergency', 'flight_id');
    }

    public function survivalEquipment()
    {
        return $this->hasMany('App\Models\FlightAtsSurvivingEquipment', 'flight_id');
    }

    public function jackets()
    {
        return $this->hasMany('App\Models\FlightAtsJacket', 'flight_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:m:i');
    }
}