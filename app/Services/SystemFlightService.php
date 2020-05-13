<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:08 PM
 */

namespace App\Services;


class SystemFlightService
{
    protected $flightTypeService;

    /**
     * SystemFlightService constructor.
     */
    public function __construct()
    {
        $this->flightTypeService = (new SystemFlightTypeService())->getAllFlightType();
    }

    /**
     * @param $params
     */
    public function save($params)
    {

    }
}