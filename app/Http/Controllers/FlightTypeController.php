<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/30/2020
 * Time: 10:02 AM
 */

namespace App\Http\Controllers;

use App\Services\FlightTypeService;
use App\Components\Response as JsonResponse;

class FlightTypeController
{
    public function getAllFlightType()
    {
        $types = (new FlightTypeService())->getAllFlightType();
        return JsonResponse::success($types);
    }
}