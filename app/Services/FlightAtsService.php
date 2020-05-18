<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 11:39 PM
 */

namespace App\Services;

use App\Models\FlightAts;

class FlightAtsService
{
    // validate equipment/save
    // validate transponders/save
    // other information
    // emergency service
    // survival equipment
    // jackets
    // attachments
    public function create($params)
    {
        $equipments = (new FlightEquipmentService())->createAtsEquipment($params);
        return $equipments;
    }
}