<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/24/2020
 * Time: 1:20 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FlightAts extends Model
{


  protected $with = ['equipments', 'transponders', 'transponderProperties',
      'otherInformation', 'emergency', 'survivalEquipment', 'jackets', 'dinghies'];

  protected $fillable = [
      'aircraft_identification', 'ats_flight_rules_id', 'aircraft_type', 'wake_turbulence_category_id',
      'departure', 'cruising_speed', 'level', 'route', 'destination', 'total_eet', 'alternate_one',
      'alternate_two', 'endurance', 'persons_on_board', 'filed_by', 'additional_requirement', 'number',
      'capacity', 'status_id', 'remarks', 'pilot_in_command', 'color_markings', 'flight_type_id', 'flight_type_id',
      'alternate_one', 'alternate_two', 'time', 'official_remarks', 'operator_id', 'accepted_by', 'flight_date'
  ];

  public function equipments()
  {
      return $this->hasMany('App\Models\FlightAtsEquipment', 'flight_id');
  }

  public function transponders()
  {
      return $this->hasOne('App\Models\FlightAtsTransponder', 'flight_id');
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
        return $this->hasOne('App\Models\FlightAtsEmergency', 'flight_id');
    }

    public function survivalEquipment()
    {
        return $this->hasOne('App\Models\FlightAtsSurvivingEquipment', 'flight_id');
    }

    public function jackets()
    {
        return $this->hasOne('App\Models\FlightAtsJacket', 'flight_id');
    }

    public function dinghies()
    {
        return $this->hasOne('App\Models\FlightAtsDinghies', 'flight_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("Y-m-d H:m");
    }

    public function operator()
    {
        return $this->hasOne('App\Models\Operator', 'id', 'operator_id');
    }
}