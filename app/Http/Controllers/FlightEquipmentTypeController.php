<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/1/2020
 * Time: 6:57 PM
 */

namespace App\Http\Controllers;

use App\Services\FlightEquipmentTypeService;
use App\Components\Response as JsonResponse;

class FlightEquipmentTypeController extends Controller
{
    public function getAllFlightEquipmentType()
    {
        $types = (new FlightEquipmentTypeService())->getAllFlightEquipmentType();
        return JsonResponse::success($types);
    }
}