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
use App\Components\Auth;

class SystemFlightController extends Controller
{
    public function getAll()
    {
        $system_flights = (new SystemFlightService())->getAll();
        return JsonResponse::success($system_flights);
    }

    public function getAllSent(Auth $auth)
    {
        $system_flights = (new SystemFlightService())->getAllSent($auth);
        return JsonResponse::success($system_flights);
    }

    public function getAllDraft(Auth $auth)
    {
        $system_flights = (new SystemFlightService())->getAllDraft($auth);
        return JsonResponse::success($system_flights);
    }

    public function types()
    {
        $types = (new SystemFlightService())->types();
        return JsonResponse::success($types);
    }
}