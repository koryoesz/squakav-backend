<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:08 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\SystemFlight;
use Illuminate\Support\Facades\Config;
use \Carbon\Carbon;

class SystemFlightService
{

    protected $system_flight;

    public function __construct()
    {
        $this->system_flight = Config::get('constant_system_flight_type');
    }
    /**
     * @param $params
     */

    public static function save($params)
    {
        $validator = Validator::make($params, [
            'flight_id' => 'numeric',
            'system_flight_types_id' => 'numeric',

        ]);
        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $system_flight = DB::table('system_flights')->insert([
            'flight_id' => $params['flight_id'],
              'system_flight_types_id' => $params['system_flight_types_id'],
                'date' => date("Y-m-d")
        ]);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $flights = SystemFlight::all();
        // get distinct records
        $dates = DB::table('system_flights')->distinct()
            ->get(['date']);

        $arr = [];

        foreach($dates as $date){
            // create temp arr that will store
            // value of true comparison
            $temp_flight_arr = [];
            foreach($flights as $key => $flight){
                // check if date from distinct is
                // equals date from flight object
                if($date->date == $flight->date){
                    $temp_flight_arr[] = $flight;
                }

            }
            // pass all true comparison to be formatted
            $format_arr = ['date' => $date->date, 'flights' => $temp_flight_arr];
            $arr[] = $format_arr;
        }
        return $arr;
    }

    public function types()
    {
        if(isset($this->system_flight))
        {
            return $this->system_flight;
        }
        return [];
    }
}