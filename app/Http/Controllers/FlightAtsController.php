<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/18/2020
 * Time: 11:47 AM
 */

namespace App\Http\Controllers;

use App\Components\Response;
use App\Models\FlightAts;
use App\Services\FlightAtsService;
use App\Components\Response as JsonResponse;
use Illuminate\Http\Request;
use App\Components\Util;
use App\Components\Auth;

class FlightAtsController extends Controller
{
    public function create(Request $request, Auth $auth)
    {
        $flight = (new FlightAtsService())->create(Util::getRequestBody($request), $auth);
        return JsonResponse::success($flight);
    }

    public function sentFlights(Request $request)
    {
        $flights = (new FlightAtsService())->getAllSent();
        return JsonResponse::success($flights);
    }

    public function getOneSent($id)
    {
        $flight = (new FlightAtsService())->getOneSent($id);
        return JsonResponse::success($flight);
    }

    public function approvedFlights()
    {
        $flight = (new FlightAtsService())->approvedFlights();
        return JsonResponse::success($flight);
    }

    public function getOneApproved($id)
    {
        $flight = (new FlightAtsService())->getOneApproved($id);
        return JsonResponse::success($flight);
    }

    public function draft(Request $request, Auth $auth)
    {
        $flight = (new FlightAtsService())->draft(Util::getRequestBody($request), $auth);
        return JsonResponse::success($flight);
    }

    public function getOneDraft($id)
    {
        $flight = (new FlightAtsService())->getOneDraft($id);
        return JsonResponse::success($flight);
    }

    public function updateDraft( Request $request, $flight_id)
    {
        $flight = (new FlightAtsService())->updateDraft($flight_id, Util::getRequestBody($request));
        return JsonResponse::success($flight);
    }

}