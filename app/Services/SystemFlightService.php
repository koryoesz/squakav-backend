<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:08 PM
 */

namespace App\Services;

use App\Models\Ais;
use App\Models\FlightAts;
use App\Models\UserType;
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\SystemFlight;
use App\Models\SystemFightType;
use Illuminate\Support\Facades\Config;
use App\Models\Status;
use App\Components\Auth;
use App\Components\Response as MyResponse;
use App\Components\ErrorCode;
use App\Components\Exception as MyException;
use App\Components\Util;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\Tower;

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

    public static function save($params, Auth $auth, $ais = false)
    {
        $validator = Validator::make($params, [
            'flight_id' => 'numeric',
            'system_flight_types_id' => 'numeric'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        if($ais){
            return DB::table('system_flights')->insert([
                'flight_id' => $params['flight_id'],
                'system_flight_types_id' => $params['system_flight_types_id'],
                'operator_id' => $auth->getId(),
                'date' => date("Y-m-d"),
                'status_id' => isset($params['status_id']) ? $params['status_id'] : 1,
                'user_type_id' => UserType::TYPE_AIS
            ]);
        }

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
                })->where('status_id', Status::ACTIVE)
                    ->with('operator')
                    ->orderBy('created_at', 'desc')->get();

            } else {

                $dates = DB::table('system_flights')
                    ->where(function($query) use ($auth){
                        $query->where('status_id', Status::ACTIVE)
                        ->orWhere('status_id', Status::DECLINED);
                    })->where('operator_id', $auth->getId())->distinct()->get(['date']);

                if($dates->count() == 0){
                    return [];
                }


                $flights = DB::table('system_flights')
                    ->where(function($query) use ($auth){
                        $query->where('status_id', Status::ACTIVE)
                            ->orWhere('status_id', Status::DECLINED);
                    })->where('operator_id', $auth->getId())->orderBy('created_at', 'desc')->get();

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
     * @return array
     */
    public function getAllSentAts(Auth $auth)
    {
        $flights = null;
        $dates = null;
        $arr = [];

        if(!empty($auth)) {

            if ($auth->getType() == UserType::TYPE_AIS) {

                $dates = DB::table('system_flights')
                    ->where('status_id', Status::ACTIVE)->distinct()
                    ->where('system_flight_types_id', SystemFightType::ATS)
                    ->get(['date']);

                if($dates->count() == 0){
                    return [];
                }

                $user = Ais::find($auth->getId());

                $flights = SystemFlight::whereHas('operator', function ($query) use ($user) {
                    $query->whereHas('state', function ($query) use ($user) {
                        $query->where('id', $user->state->id);
                    });
                })->where('status_id', Status::ACTIVE)
                    ->where('system_flight_types_id', SystemFightType::ATS)
                    ->with('operator')
                    ->orderBy('created_at', 'desc')->get();

            } else {

                $dates = DB::table('system_flights')
                    ->where('status_id', Status::ACTIVE)
                    ->where('system_flight_types_id', SystemFightType::ATS)
                    ->where('operator_id', $auth->getId())
                    ->distinct()
                    ->get(['date']);

                if($dates->count() == 0){
                    return [];
                }

                $flights = SystemFlight::where('status_id', Status::ACTIVE)
                    ->where('operator_id', $auth->getId())
                    ->where('system_flight_types_id', SystemFightType::ATS)
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
                        // add time from flight ats FOR AIS
                        if($auth->getType() == UserType::TYPE_AIS){
                            if($flight->system_flight_types_id == SystemFightType::ATS){
                                $temp_flight = FlightAts::find($flight->flight_id);
                                $flight->time = $temp_flight->time;
                            }
                        }
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


    public function getAllSentRpl(Auth $auth)
    {
        $flights = null;
        $dates = null;
        $arr = [];

        if(!empty($auth)) {

            if ($auth->getType() == UserType::TYPE_AIS) {

                $dates = DB::table('system_flights')
                    ->where('status_id', Status::ACTIVE)->distinct()
                    ->where('system_flight_types_id', SystemFightType::RPL)
                    ->get(['date']);

                if($dates->count() == 0){
                    return [];
                }

                $user = Ais::find($auth->getId());

                $flights = SystemFlight::whereHas('operator', function ($query) use ($user) {
                    $query->whereHas('state', function ($query) use ($user) {
                        $query->where('id', $user->state->id);
                    });
                })->where('status_id', Status::ACTIVE)
                    ->where('system_flight_types_id', SystemFightType::RPL)
                    ->with('operator')
                    ->orderBy('created_at', 'desc')->get();

            } else {

                $dates = DB::table('system_flights')
                    ->where('status_id', Status::ACTIVE)
                    ->where('system_flight_types_id', SystemFightType::RPL)
                    ->where('operator_id', $auth->getId())
                    ->distinct()
                    ->get(['date']);

                if($dates->count() == 0){
                    return [];
                }

                $flights = SystemFlight::where('status_id', Status::ACTIVE)
                    ->where('operator_id', $auth->getId())
                    ->where('system_flight_types_id', SystemFightType::RPL)
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

    /**
     * @param Auth $auth
     * @return array|\Illuminate\Http\JsonResponse
     */
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
                    ->where('status_id', Status::APPROVED)
                    ->where('operator_id', $auth->getId())
                    ->distinct()
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

    /**
     * @param Auth $auth
     * @return array
     * @throws MyException
     */
    public function overview(Auth $auth)
    {
        if ($auth->getType() == UserType::TYPE_AIS) {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }

        $total_number_sent_ats = SystemFlight::where('status_id', Status::ACTIVE)
            ->where(function($query){
                $query->where('system_flight_types_id', $this->system_flight['ats']['id']);
            })->where('operator_id', $auth->getId())->count();

        $total_number_sent_rpl = SystemFlight::where('status_id', Status::ACTIVE)
            ->where(function($query){
                $query->where('system_flight_types_id', $this->system_flight['rpl']['id']);
            })->where('operator_id', $auth->getId())->count();

        $total_number_declined = SystemFlight::where('status_id', Status::DECLINED)
            ->where('operator_id', $auth->getId())->count();

        $total_number_drafted = SystemFlight::where('status_id', Status::DRAFTED)
            ->where('operator_id', $auth->getId())->count();

        return [
                'total_number_sent_ats' => $total_number_sent_ats,
                'total_number_sent_rpl' => $total_number_sent_rpl,
                'total_number_declined_flights' => $total_number_declined,
                'total_number_drafted' => $total_number_drafted
            ];
    }

    /**
     * @param Auth $auth
     * @return array
     * @throws MyException
     */
    public function overviewAis(Auth $auth)
    {
        if ($auth->getType() != UserType::TYPE_AIS) {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }

        $user = Ais::find($auth->getId());

        $total_number_sent_ats = SystemFlight::whereHas('operator', function ($query) use ($user) {
            $query->whereHas('state', function ($query) use ($user) {
                $query->where('id', $user->state->id);
            });
        })->where('status_id', Status::ACTIVE)
            ->where('system_flight_types_id', SystemFightType::ATS)
            ->count();

        $total_number_sent_rpl = SystemFlight::whereHas('operator', function ($query) use ($user) {
            $query->whereHas('state', function ($query) use ($user) {
                $query->where('id', $user->state->id);
            });
        })->where('status_id', Status::ACTIVE)
            ->where('system_flight_types_id', SystemFightType::RPL)
            ->count();


        return [
            'total_number_sent_ats' => $total_number_sent_ats,
            'total_number_sent_rpl' => $total_number_sent_rpl
        ];
    }

    /**
     * @param Auth $auth
     * @return mixed
     * @throws MyException
     */
    public function getRadioLogDates(Auth $auth)
    {
        if($auth->getType() == UserType::TYPE_OPERATOR)
        {

            $dates = SystemFlight::whereHas('operator', function($query) use ($auth){
                    $query->whereHas('organisation', function ($query) use ($auth){
                        $query->where('id', $auth->getOrganisationId());
                    });
                })->where('status_id', Status::APPROVED)->distinct()->get(['date']);

            return $dates;
        }

        throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);

    }

    /**
     * @param Auth $auth
     * @param $date
     */
    public function getRadioLogFlights(Auth $auth, $params)
    {
        $validator = Validator::make($params, [
            'date' => 'required|date:Y-m-d'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $date = $params['date'];
        $flights = null;

        if($auth->getType() == UserType::TYPE_OPERATOR)
        {
            $flights_query = SystemFlight::whereHas('operator', function($query) use ($auth) {
                $query->whereHas('organisation', function ($query) use ($auth) {
                    $query->where('id', $auth->getOrganisationId());
                });
            })->where('status_id', Status::APPROVED)
                ->where('date', $date)->orderBy('created_at', 'desc')->get();


            foreach($flights_query as $flight)
            {
                $flight_class = SystemFightType::getClassById($flight->system_flight_types_id);
                $temp_flight = $flight_class::find($flight->flight_id);

                if($flight->system_flight_types_id == SystemFightType::RPL){

                    foreach ($temp_flight->flights as $fl){
                        $flights[] = $fl;
                    }
                }
                else{
                    $flights[] = $temp_flight;
                }
            }

        }

        return $flights;
    }

    /**
     * @param Auth $auth
     */
    public function getOutboundFlights(Auth $auth, $params)
    {
        if ($auth->getType() != UserType::TYPE_AIS) {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }

        $validator = Validator::make($params, [
            'date' => 'required|date:Y-m-d'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $date = $params['date'];

        $day = Util::getDayFromDate($date);

        $flights = null;

        $user = Ais::find($auth->getId());

        $flights_query = SystemFlight::whereHas('operator', function ($query) use ($user) {
            $query->whereHas('state', function ($query) use ($user) {
                $query->where('id', $user->state->id);
            });
        })->where('status_id', Status::APPROVED)
            ->orderBy('created_at', 'desc')->get();

        $flights = [];

        foreach($flights_query as $flight)
        {
            $flight_class = SystemFightType::getClassById($flight->system_flight_types_id);
            $temp_flight = $flight_class::find($flight->flight_id);

            if($flight->system_flight_types_id == SystemFightType::RPL){

                if($temp_flight->departure_airport_id == $user->airport->id){
                    foreach ($temp_flight->flights as $fl){

                        $query_temp = $fl->whereHas('days', function($query) use ($day, $fl){
                            $query->where('id', $fl->flight_rpl_days_id)->where($day, 1);
                        })->get();

                        if($query_temp->count() > 0){
                            $flights[] = $fl;
                        }
                    }
                }
            }
            else{
                if(isset($temp_flight->departure_airport_id) &&
                    $temp_flight->departure_airport_id == $user->airport->id
                    && $temp_flight->flight_date == $date)
                {
                    $flights[] = $temp_flight::where('id', $temp_flight->id)
                        ->with('otherInformation.relation')->get()[0];
                }
                else{
                    if(isset($temp_flight->departure)
                        && $temp_flight->departure == $user->airport->icao_code
                        && $temp_flight->flight_date == $date){
                        $flights[] = $temp_flight;
                    }
                }
            }
        }


        return $flights;

    }

    /**
     * @param Auth $auth
     */
    public function getInboundFlights(Auth $auth, $params)
    {
        if ($auth->getType() != UserType::TYPE_AIS) {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }

        $validator = Validator::make($params, [
            'date' => 'required|date:Y-m-d'
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $date = $params['date'];

        $day = Util::getDayFromDate($date);

        $user = Ais::find($auth->getId());

        $flights_query = SystemFlight::where('status_id', Status::APPROVED)
            ->orderBy('created_at', 'desc')->get();

        $flights = [];

        foreach($flights_query as $flight)
        {
            $flight_class = SystemFightType::getClassById($flight->system_flight_types_id);
            $temp_flight = $flight_class::find($flight->flight_id);

            if($flight->system_flight_types_id == SystemFightType::RPL){

                foreach ($temp_flight->flights as $fl){
                    if(isset($fl->destination_airport_id)){
                        if($fl->destination_airport_id == $user->airport->id){

                            $query_temp = $fl->whereHas('days', function($query) use ($day, $fl){
                                $query->where('id', $fl->flight_rpl_days_id)->where($day, 1);
                            })->get();

                            if($query_temp->count() > 0){
                                $flights[] = $fl;
                            }
                        }
                    }
                    else {
                            if (isset($fl->destination) && $fl->destination == $user->airport->icao_code) {

                                $query_temp = $fl->whereHas('days', function($query) use ($day, $fl){
                                    $query->where('id', $fl->flight_rpl_days_id)->where($day, 1);
                                })->get();
                                if(!$query_temp->count() > 0){
                                    $flights[] = $fl;
                                }
                            }
                        }
                    }
            }
            else{
                if(isset($temp_flight->destination_airport_id) &&
                    $temp_flight->destination_airport_id == $user->airport->id
                    && $temp_flight->flight_date == $date)
                {
                    $flights[] = $temp_flight::where('id', $temp_flight->id)
                        ->with('otherInformation.relation')->get()[0];
                }
                else{
                    if(isset($temp_flight->destination)
                        && $temp_flight->destination == $user->airport->icao_code
                        && $temp_flight->flight_date == $date
                        ){
                        $flights[] = $temp_flight;
                    }
                }
            }
        }

        return $flights;
    }

    /**
     * @param Auth $auth
     * @return array
     * @throws MyException
     */
    public function getDayToDayListingInbound(Auth $auth)
    {
        if ($auth->getType() != UserType::TYPE_TOWER) {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }

        $today = Carbon::parse(Carbon::today())->format("Y-m-d");
        $day = Util::getDayFromDate($today);

        $user = Tower::find($auth->getId());

        $flights_query = SystemFlight::where('status_id', Status::APPROVED)
            ->orderBy('created_at', 'desc')->get();

        $flights = [];

        foreach($flights_query as $flight)
        {
            $flight_class = SystemFightType::getClassById($flight->system_flight_types_id);
            $temp_flight = $flight_class::find($flight->flight_id);

            if($flight->system_flight_types_id == SystemFightType::RPL){

                foreach ($temp_flight->flights as $fl){
                    if(isset($fl->destination_airport_id)){
                        if($fl->destination_airport_id == $user->airport->id){

                            $query_temp = $fl->whereHas('days', function($query) use ($day, $fl){
                                $query->where('id', $fl->flight_rpl_days_id)->where($day, 1);
                            })->get();

                            if($query_temp->count() > 0){
                                $flights[] = $fl;
                            }
                        }
                    }
                    else {
                        if (isset($fl->destination) && $fl->destination == $user->airport->icao_code) {

                            $query_temp = $fl->whereHas('days', function($query) use ($day, $fl){
                                $query->where('id', $fl->flight_rpl_days_id)->where($day, 1);
                            })->get();
                            if(!$query_temp->count() > 0){
                                $flights[] = $fl;
                            }
                        }
                    }
                }
            }
            else{
                if(isset($temp_flight->destination_airport_id) &&
                    $temp_flight->destination_airport_id == $user->airport->id
                    && $temp_flight->flight_date == $today)
                {
                    $tmp = $temp_flight;
                    $tmp->operator = $temp_flight->operator;
                    $flights[] = $tmp;
                }
                else{
                    if(isset($temp_flight->destination)
                        && $temp_flight->destination == $user->airport->icao_code
                        && $temp_flight->flight_date == $today
                    ){
                        $tmp = $temp_flight;
                        $tmp->operator = $temp_flight->operator;
                        $flights[] = $tmp;
                    }
                }
            }
        }

        $collection = collect($flights);
        $sorted = $collection->sortBy('time');

        return $sorted->values()->all();
    }

    public function getDayToDayListingOutbound(Auth $auth)
    {
        if ($auth->getType() != UserType::TYPE_TOWER) {
            throw new MyException('You are not Authorized.', ErrorCode::ACCESS_DENIED);
        }

        $today = Carbon::parse(Carbon::today())->format("Y-m-d");
        $day = Util::getDayFromDate($today);

        $user = Tower::find($auth->getId());

        $flights_query = SystemFlight::where('status_id', Status::APPROVED)
            ->orderBy('created_at', 'desc')->get();

        $flights = [];

        foreach($flights_query as $flight)
        {
            $flight_class = SystemFightType::getClassById($flight->system_flight_types_id);
            $temp_flight = $flight_class::find($flight->flight_id);

            if($flight->system_flight_types_id == SystemFightType::RPL){

                if($temp_flight->departure_airport_id == $user->airport->id){
                    foreach ($temp_flight->flights as $fl){

                        $query_temp = $fl->whereHas('days', function($query) use ($day, $fl){
                            $query->where('id', $fl->flight_rpl_days_id)->where($day, 1);
                        })->get();

                        if($query_temp->count() > 0){
                            $flights[] = $fl;
                        }
                    }
                }
            }
            else{
                if(isset($temp_flight->departure_airport_id) &&
                    $temp_flight->departure_airport_id == $user->airport->id
                    && $temp_flight->flight_date == $today)
                {
                    $tmp = $temp_flight;
                    $tmp->operator = $temp_flight->operator;
                    $flights[] = $tmp;
                }
                else{
                    if(isset($temp_flight->departure)
                        && $temp_flight->departure == $user->airport->icao_code
                        && $temp_flight->flight_date == $today)
                    {
                        $tmp = $temp_flight;
                        $tmp->operator = $temp_flight->operator;
                        $flights[] = $tmp;
                    }
                }
            }
        }

        $collection = collect($flights);
        $sorted = $collection->sortBy('time');

        return $sorted->values()->all();
    }
}