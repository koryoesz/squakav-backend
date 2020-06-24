<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:08 PM
 */

namespace App\Services;

use App\Models\Ais;
use App\Models\UserType;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\SystemFlight;
use Illuminate\Support\Facades\Config;
use App\Models\Status;
use App\Components\Auth;
use App\Components\Response as MyResponse;
use App\Components\ErrorCode;

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

    public static function save($params, Auth $auth)
    {
        $validator = Validator::make($params, [
            'flight_id' => 'numeric',
            'system_flight_types_id' => 'numeric'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $system_flight = DB::table('system_flights')->insert([
            'flight_id' => $params['flight_id'],
            'system_flight_types_id' => $params['system_flight_types_id'],
            'operator_id' => $auth->getId(),
            'date' => date("Y-m-d"),
            'status_id' => isset($params['status_id']) ? $params['status_id'] : 1
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

        foreach ($dates as $date) {
            // create temp arr that will store
            // value of true comparison
            $temp_flight_arr = [];
            foreach ($flights as $key => $flight) {
                // check if date from distinct is
                // equals date from flight object
                if ($date->date == $flight->date) {
                    $temp_flight_arr[] = $flight;
                }

            }
            // pass all true comparison to be formatted
            $format_arr = ['date' => $date->date, 'flights' => $temp_flight_arr];
            $arr[] = $format_arr;
        }
        return $arr;

    }

    /**
     * @return array
     */
    public function getAllSent(Auth $auth)
    {
        $flights = null;
        $dates = null;
        $arr = [];

        if(!empty($auth)) {

            if ($auth->getType() == UserType::TYPE_AIS) {

                $dates = DB::table('system_flights')
                    ->where('status_id', Status::ACTIVE)->distinct()
                    ->get(['date']);

                if($dates->count() == 0){
                    return [];
                }

                $user = Ais::find($auth->getId());

                $flights = SystemFlight::whereHas('operator', function ($query) use ($user) {
                    $query->whereHas('state', function ($query) use ($user) {
                        $query->where('id', $user->state->id);
                    });
                })->where('status_id', Status::ACTIVE)->orderBy('created_at', 'desc')->get();

            } else {

                $dates = DB::table('system_flights')
                    ->where('status_id', Status::ACTIVE)->distinct()
                    ->get(['date']);

                if($dates->count() == 0){
                    return [];
                }

                $flights = SystemFlight::where('status_id', Status::ACTIVE)
                    ->where('operator_id', $auth->getId())
                    ->orderBy('created_at', 'desc')->get();

            }


            foreach ($dates as $date) {
                // create temp arr that will store
                // value of true comparison
                $temp_flight_arr = [];
                foreach ($flights as $key => $flight) {
                    // check if date from distinct is
                    // equals date from flight object
                    if ($date->date == $flight->date) {
                        $temp_flight_arr[] = $flight;
                    }

                }
                // pass all true comparison to be formatted
                $format_arr = ['date' => $date->date, 'flights' => $temp_flight_arr];
                $arr[] = $format_arr;
            }
            return $arr;
        }

        return MyResponse::error(ErrorCode::NO_AUTH, 'Access Denied.');
    }

    /**
     * @return array|mixed
     */
    public function types()
    {
        if(isset($this->system_flight))
        {
            return $this->system_flight;
        }
        return [];
    }

    public function getAllDraft(Auth $auth)
    {
        if(!empty($auth)) {

            $flights = SystemFlight::where('status_id', Status::DRAFTED)
                ->where('operator_id', $auth->getId())
                ->orderBy('created_at', 'desc')->get();
            // get distinct records
            $dates = DB::table('system_flights')
                ->where('status_id', Status::DRAFTED)
                ->where('operator_id', $auth->getId())
                ->distinct()
                ->get(['date']);

            $arr = [];

            foreach ($dates as $date) {
                // create temp arr that will store
                // value of true comparison
                $temp_flight_arr = [];
                foreach ($flights as $key => $flight) {
                    // check if date from distinct is
                    // equals date from flight object
                    if ($date->date == $flight->date) {
                        $temp_flight_arr[] = $flight;
                    }

                }
                // pass all true comparison to be formatted
                $format_arr = ['date' => $date->date, 'flights' => $temp_flight_arr];
                $arr[] = $format_arr;
            }
            return $arr;
        }

        return MyResponse::error(ErrorCode::NO_AUTH, 'Access Denied.');
    }

    public function getAllApproved(Auth $auth)
    {
        $flights = null;
        $dates = null;
        $arr = [];

        if(!empty($auth)) {

            if ($auth->getType() == UserType::TYPE_AIS) {

                $dates = DB::table('system_flights')
                    ->where('status_id', Status::APPROVED)->distinct()
                    ->get(['date']);

                if($dates->count() == 0){
                    return [];
                }

                $user = Ais::find($auth->getId());

                $flights = SystemFlight::whereHas('operator', function ($query) use ($user) {
                    $query->whereHas('state', function ($query) use ($user) {
                        $query->where('id', $user->state->id);
                    });
                })->where('status_id', Status::APPROVED)->orderBy('created_at', 'desc')->get();

            } else {

                $dates = DB::table('system_flights')
                    ->where('status_id', Status::APPROVED)->distinct()
                    ->get(['date']);

                if($dates->count() == 0){
                    return [];
                }

                $flights = SystemFlight::where('status_id', Status::APPROVED)
                    ->where('operator_id', $auth->getId())
                    ->orderBy('created_at', 'desc')->get();

            }


            foreach ($dates as $date) {
                // create temp arr that will store
                // value of true comparison
                $temp_flight_arr = [];
                foreach ($flights as $key => $flight) {
                    // check if date from distinct is
                    // equals date from flight object
                    if ($date->date == $flight->date) {
                        $temp_flight_arr[] = $flight;
                    }

                }
                // pass all true comparison to be formatted
                $format_arr = ['date' => $date->date, 'flights' => $temp_flight_arr];
                $arr[] = $format_arr;
            }
            return $arr;
        }

        return MyResponse::error(ErrorCode::NO_AUTH, 'Access Denied.');
    }
}