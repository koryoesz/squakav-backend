<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/26/2020
 * Time: 10:16 PM
 */

namespace App\Http\Controllers;

use App\Components\Response as JsonResponse;
use Illuminate\Http\Request;
use App\Components\Util;
use App\Components\Auth;
use App\Services\FlightRplService;

class FlightRplController extends Controller
{
    public function create(Request $request, Auth $auth)
    {
        $flight = (new FlightRplService())->createFlightPlan(Util::getRequestBody($request), $auth);
        return JsonResponse::success($flight);
    }

    public function getAllSent(Auth $auth)
    {
        $flights = (new FlightRplService())->getAllSent($auth);
        return JsonResponse::success($flights);
    }

    public function getOneSent(Auth $auth, $id)
    {
        $flights = (new FlightRplService())->getOneSent($auth, $id);
        return JsonResponse::success($flights);
    }
}