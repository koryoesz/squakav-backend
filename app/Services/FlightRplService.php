<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/26/2020
 * Time: 9:42 PM
 */

namespace App\Services;

use App\Models\FlightRpl;
use Illuminate\Support\Facades\DB;
use App\Components\ErrorCode;
use Illuminate\Support\Facades\Config;
use App\Components\EaseFlightValidation;
use App\Components\Exception as MyException;
use App\Components\Auth;
use App\Models\Status;
use App\Models\UserType;

class FlightRplService
{
    protected $system_flight;

    public function __construct()
    {
        $this->system_flight = Config::get('constant_system_flight_type');
    }

    /**
     * @param $params
     * @param Auth $auth
     * @return mixed
     * @throws MyException
     */
    public function createFlightPlan($params, Auth $auth)
    {
        if (empty($this->system_flight)){
            throw new MyException('Could not find system config', ErrorCode::INTERNAL_ERROR);
        }

        EaseFlightValidation::forceValidateRpl($params);

        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($params, $auth){
                // create flight

                $params['operator_id'] = $auth->getId();
                $flight = FlightRpl::create($params);

                if(empty($flight)){
                    throw (new MyException('Create Flight Record Failed', ErrorCode::INTERNAL_ERROR));
                }

                // store for system flight
                // build params for system flight ats
                $system_flight_params = [
                    'flight_id' => $flight->id,
                    'system_flight_types_id' => $this->system_flight['rpl']['id'],
                    'status_id' => isset($params['status_id']) ? $params['status_id'] : 1
                ];

                (new SystemFlightService())::save($system_flight_params, $auth);

                (new FlightRplFlightsService())::createFlights($params['flights'], $flight->id, $system_flight_params);

                return $flight;
            });

    }

    public function getAllSent(Auth $auth)
    {
        $flights = FlightRpl::where('status_id', Status::ACTIVE)
            ->where('operator_id', $auth->getId())
            ->with('flights.days')
            ->orderBy('created_at', 'desc')->get();
        return $flights;
    }

    public function getOneSent(Auth $auth, $id)
    {
        if($auth->getType() == UserType::TYPE_AIS)
        {
            $flight = FlightRpl::where('id', $id)
                ->where('status_id', Status::ACTIVE)
                ->with('flights.days')
                ->first();
            return $flight;
        }
        $flight = FlightRpl::where('id', $id)
            ->where('status_id', Status::ACTIVE)
            ->where('operator_id', $auth->getId())
            ->with('flights.days')
            ->first();
        return $flight;
    }

    public function draft($params, Auth $auth)
    {
        if (empty($this->system_flight)) {
            throw new MyException('Could not find system config', ErrorCode::INTERNAL_ERROR);
        }


        return DB::transaction(/**
         * @return mixed
         * @throws MyException
         */
            function () use ($params, $auth) {
                // create flight

                $params['operator_id'] = $auth->getId();
                $params['status_id'] = Status::DRAFTED;

                $flight = FlightRpl::create($params);

                if (empty($flight)) {
                    throw (new MyException('Create Flight Record Failed', ErrorCode::INTERNAL_ERROR));
                }

                // store for system flight
                // build params for system flight ats
                $system_flight_params = [
                    'flight_id' => $flight->id,
                    'system_flight_types_id' => $this->system_flight['rpl']['id'],
                    'status_id' => Status::DRAFTED,
                    'user_type_id' =>  $auth->getType()
                ];

                (new SystemFlightService())::save($system_flight_params, $auth);

                (new FlightRplFlightsService())::createFlights(isset($params['flights'])
                    ? $params['flights'] : [],
                    $flight->id, $system_flight_params);

                return $flight;

            });
    }

    /**
     * @param $id
     * @return mixed
     * Return single drafted flight
     */
    public function getOneDraft(Auth $auth, $id)
    {
        $flight = FlightRpl::where('id', $id)
            ->where('status_id', Status::DRAFTED)
            ->where('operator_id', $auth->getId())
            ->with('flights.days')
            ->first();
        return $flight;
    }
}