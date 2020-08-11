<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/5/2020
 * Time: 3:03 PM
 */

namespace App\Http\Controllers;

use App\Services\SystemFlightService;
use App\Components\Response as JsonResponse;
use App\Components\Auth;

class TowerController extends Controller
{

    public  function getDayToDayListingInbound(Auth $auth)
    {
        $flights = (new SystemFlightService())->getDayToDayListingInbound($auth);
        return JsonResponse::success($flights);
    }

    public  function getDayToDayListingOutbound(Auth $auth)
    {
        $flights = (new SystemFlightService())->getDayToDayListingOutbound($auth);
        return JsonResponse::success($flights);
    }
}