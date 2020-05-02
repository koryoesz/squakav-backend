<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/1/2020
 * Time: 6:10 PM
 */

namespace App\Http\Controllers;
use App\Services\FlightEquipmentService;
use App\Components\Response as JsonResponse;

class FlightEquipmentController
{
    public function getAllFlightEquipment()
    {
        $equipments = (new FlightEquipmentService())->getAllFlightEquipment();
        return JsonResponse::success($equipments);
    }
}