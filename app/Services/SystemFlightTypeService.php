<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:07 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\Config;

class SystemFlightTypeService
{
    protected $flightTypes;

    public function __construct()
    {
        $this->flightTypes = Config::get('constant_system_flight_type');
    }

    public function getAllFlightType()
    {
        return $this->flightTypes;
    }
}