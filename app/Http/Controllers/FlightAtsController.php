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

    public function sentFlights(Request $request, Auth $auth)
    {
        $flights = (new FlightAtsService())->getAllSent($auth);
        return JsonResponse::success($flights);
    }

    public function getOneSent(Auth $auth, $id)
    {
        $flight = (new FlightAtsService())->getOneSent($auth, $id);
        return JsonResponse::success($flight);
    }

    public function getOneApproved(Auth $auth, $id)
    {
        $flight = (new FlightAtsService())->getOneApproved($auth, $id);
        return JsonResponse::success($flight);
    }

    public function draft(Request $request, Auth $auth)
    {
        $flight = (new FlightAtsService())->draft(Util::getRequestBody($request), $auth);
        return JsonResponse::success($flight);
    }

    public function getOneDraft(Auth $auth, $id)
    {
        $flight = (new FlightAtsService())->getOneDraft($auth, $id);
        return JsonResponse::success($flight);
    }

    public function updateDraft( Request $request, $flight_id, Auth $auth)
    {
        $flight = (new FlightAtsService())->updateDraft($flight_id, Util::getRequestBody($request), $auth);
        return JsonResponse::success($flight);
    }

    public function getAllApproved(Auth $auth)
    {
        $flights = (new FlightAtsService())->getAllApproved($auth);
        return JsonResponse::success($flights);
    }

}