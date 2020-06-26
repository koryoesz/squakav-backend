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
        $equipments = null;
        $emergency = null;

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

                (new FlightRplFlightsService())::createFlights($params['flights'], $flight->id);

                return $flight;
            });

    }
}