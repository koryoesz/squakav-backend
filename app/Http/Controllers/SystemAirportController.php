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

class SystemAirportController extends Controller
{
    public function getAll()
    {
        $system_airports = (new SystemAirportService())->getAll();
        return JsonResponse::success($system_airports);
    }
}