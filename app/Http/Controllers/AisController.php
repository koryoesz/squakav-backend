<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/27/2020
 * Time: 12:32 PM
 */

namespace App\Http\Controllers;

use App\Services\FlightAtsService;
use App\Components\Response as JsonResponse;
use App\Services\FlightRplService;
use Illuminate\Http\Request;
use App\Components\Auth;
use App\Components\Util;

class AisController extends Controller
{

    public function approveAts(Request $request, Auth $auth)
    {
        $response = (new FlightAtsService())->approve($auth, $request->all());
        return JsonResponse::success($response);
    }

    public function approvedFlights()
    {
        $flight = (new FlightAtsService())->approvedFlights();
        return JsonResponse::success($flight);
    }

    public function approveRpl(Request $request, Auth $auth)
    {
        $response = (new FlightRplService())->approve($auth, $request->all());
        return JsonResponse::success($response);
    }

    public function declineAts( Request $request, Auth $auth)
    {
        $msg = (new FlightAtsService())->decline($auth, Util::getRequestBody($request));
        return JsonResponse::success("", $msg);
    }
}