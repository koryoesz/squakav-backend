<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/26/2020
 * Time: 9:42 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Components\EaseFlightValidation;
use App\Models\FlightRplFlight;
use App\Models\Status;
use App\Models\FlightRplDay;

class FlightRplFlightsService
{
    public static function createFlights($flights, $flight_id, $system_flight = null)
    {
        $prepareParams = self::prepareAndValidateFlights($flights, $flight_id);
        $prepareSecondParam = [];

        foreach ($prepareParams as $param)
        {
            $days = (new FlightRplDaysService())->create($param['days']);
            unset($param['days']);
            $param['flight_rpl_days_id'] = $days->id;
            $prepareSecondParam[] = $param;
            // correct db insert params
            if($system_flight['status_id'] == Status::DRAFTED){
                DB::table('flight_rpl_flights')->insert($param);
            }
        }

        if($system_flight['status_id'] != Status::DRAFTED) {
            $properties = DB::table('flight_rpl_flights')->insert($prepareSecondParam);
        }
    }

    public function updateFlights($paramsArray, $flight_id)
    {
        $prepareParams = $this->prepareAndValidateFlights($paramsArray, $flight_id);

        $flights = FlightRplFlight::where('flight_rpl_id', $flight_id)->with('days')->get();

        if($flights->count() == 0)
        {
            return DB::table('flight_rpl_flights')->insert($prepareParams);
        }

        foreach ($flights as $flight)
        {
            $flight->days->delete();
            $flight->delete();
        }

        return DB::table('flight_rpl_flights')->insert($prepareParams);

    }

    private static function prepareAndValidateFlights($paramsArray, $flight_id)
    {
        $prepareParams = [];

        foreach ($paramsArray as $param)
        {
            $param['flight_rpl_id'] = $flight_id;

            EaseFlightValidation::easeValidateRplFlights($param);

            $prepareParams[] = $param;

        }

        return $prepareParams;
    }
}