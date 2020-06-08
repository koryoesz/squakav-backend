<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/21/2020
 * Time: 9:48 AM
 */

namespace App\Http\Controllers;

use App\Services\SystemFlightService;
use App\Components\Response as JsonResponse;

class SystemFlightController extends Controller
{
    public function getAll()
    {
        $system_flights = (new SystemFlightService())->getAll();
        return JsonResponse::success($system_flights);
    }

    public function getAllSent()
    {
        $system_flights = (new SystemFlightService())->getAllSent();
        return JsonResponse::success($system_flights);
    }

    public function getAllDraft()
    {
        $system_flights = (new SystemFlightService())->getAllDraft();
        return JsonResponse::success($system_flights);
    }

    public function types()
    {
        $types = (new SystemFlightService())->types();
        return JsonResponse::success($types);
    }
}