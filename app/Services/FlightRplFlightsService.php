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
    public static function createFlights($flights, $flight_id, $system_flight = null, $force = false)
    {
        $prepareParams = self::prepareAndValidateFlights($flights, $flight_id, $force);
        $prepareSecondParam = [];

        foreach ($prepareParams as $param)
        {
            $days = (new FlightRplDaysService())->create($param['days']);
            unset($param['days']);
            $param['flight_rpl_days_id'] = $days->id;
            $param['remarks'] = isset($param['remarks']) ? $param['remarks'] : '';
            $prepareSecondParam[] = $param;
            // correct db insert params
            if($system_flight['status_id'] == Status::DRAFTED){
                DB::table('flight_rpl_flights')->insert($param);
            }
        }

        if($system_flight['status_id'] != Status::DRAFTED) {
            foreach($prepareSecondParam as $p) {
                DB::table('flight_rpl_flights')->insert($p);
            }
        }
    }

    public function updateFlights($paramsArray, $flight_id, $force = false)
    {
        $prepareParams = $this->prepareAndValidateFlights($paramsArray, $flight_id, $force);

        $flights = FlightRplFlight::where('flight_rpl_id', $flight_id)->with('days')->get();

        foreach ($flights as $flight)
        {
            // delete the flights and the days attached with it
            $flight->delete();
            $flight->days->delete();
        }

        foreach ($prepareParams as $param)
        {
            $days = (new FlightRplDaysService())->create($param['days']);
            unset($param['days']);
            $param['flight_rpl_days_id'] = $days->id;
            // correct db insert params
            DB::table('flight_rpl_flights')->insert($param);

        }

    }

    private static function prepareAndValidateFlights($paramsArray, $flight_id, $force = false)
    {
        $prepareParams = [];

        if($force){
            foreach ($paramsArray as $param)
            {
                $param['flight_rpl_id'] = $flight_id;

                EaseFlightValidation::forceValidateRplFlights($param);

                $prepareParams[] = $param;

            }

            return $prepareParams;
        }
        foreach ($paramsArray as $param)
        {
            $param['flight_rpl_id'] = $flight_id;

            EaseFlightValidation::easeValidateRplFlights($param);

            $prepareParams[] = $param;

        }

        return $prepareParams;
    }
}