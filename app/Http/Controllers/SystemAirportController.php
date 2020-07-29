<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/12/2020
 * Time: 5:01 PM
 */

namespace App\Http\Controllers;

use App\Components\Response as JsonResponse;
use App\Services\SystemAirportService;
use App\Components\Auth;

class SystemAirportController extends Controller
{
    public function getAll(Auth $auth)
    {
        $system_airports = (new SystemAirportService())->getAll($auth);
        return JsonResponse::success($system_airports);
    }
}