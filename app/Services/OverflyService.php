<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/11/2020
 * Time: 3:59 PM
 */

namespace App\Services;

use App\Components\Auth;
use App\Models\FlightAtsAddressees;
use App\Models\FlightRplFlightsAddressees;
use Carbon\Carbon;
use App\Models\Ais;
use App\Components\Util;
use App\Components\Exception as MyException;
use App\Components\ErrorCode;
use App\Models\UserType;
use App\Components\ValidationException;
use Illuminate\Support\Facades\Validator;

class OverflyService
{
    protected $today;

    public function __construct()
    {
        $this->today = Carbon::parse(Carbon::today())->format("Y-m-d");
    }

    /**
     * @param Auth $auth
     * @return array
     * @throws MyException
     */
    public function ais(Auth $auth, $params)
    {
        if ($auth->getType() != UserType::TYPE_AIS) {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }

        $validator = Validator::make($params, [
            'date' => 'required|date:Y-m-d'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $flights = [];
        $date = $params['date'];
        $day = Util::getDayFromDate($date);

        $user = Ais::find($auth->getId());
        $addrs = FlightAtsAddressees::whereHas('flight', function($query) use ($date) {
                                    $query->where('flight_date', $date);
                                })
                                ->where('system_airport_id', $user->airport->id)
                                ->get();

        $addrsRpl = FlightRplFlightsAddressees::where('system_airport_id', $user->airport->id)
                                                ->get();

        foreach ($addrs as $addr){
            $flights[] = $addr->flight;
        }

        foreach ($addrsRpl as $addr){
            $temp_flight = $addr->flight;
            $query_temp = $temp_flight->whereHas('days', function($query) use ($day, $temp_flight){
                $query->where('id', $temp_flight->flight_rpl_days_id)->where($day, 1);
            })->get();

            if($query_temp->count() > 0){
//                $temp_flight->depature = $temp_flight->rplFlight->operator->airport->name;
                $flights[] = $temp_flight->with('rplFlight.operator.airport.system_airport')->get()[0];
            }
        }

        return $flights;
    }

    public function tower(Auth $auth)
    {
        if ($auth->getType() != UserType::TYPE_AIS) {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }

        $flights = [];
        $day = Util::getDayFromDate($this->today);

        $user = Ais::find($auth->getId());
        $addrs = FlightAtsAddressees::whereHas('flight', function($query) {
            $query->where('flight_date', $this->today);
        })
            ->where('system_airport_id', $user->airport->id)
            ->get();

        $addrsRpl = FlightRplFlightsAddressees::where('system_airport_id', $user->airport->id)
            ->get();

        foreach ($addrs as $addr){
            $flights[] = $addr->flight;
        }

        foreach ($addrsRpl as $addr){
            $temp_flight = $addr->flight;
            $query_temp = $temp_flight->whereHas('days', function($query) use ($day, $temp_flight){
                $query->where('id', $temp_flight->flight_rpl_days_id)->where($day, 1);
            })->get();

            if($query_temp->count() > 0){
                $flights[] = $temp_flight;
            }
        }

        return $flights;
    }
}