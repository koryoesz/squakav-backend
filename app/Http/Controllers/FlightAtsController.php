<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/18/2020
 * Time: 11:47 AM
 */

namespace App\Http\Controllers;

use App\Components\Response;
use App\Services\FlightAtsService;
use App\Components\Response as JsonResponse;
use Illuminate\Http\Request;
use App\Components\Util;

class FlightAtsController extends Controller
{
    public function create(Request $request)
    {
        $flight = (new FlightAtsService())->create(Util::getRequestBody($request));
        return JsonResponse::success($flight);
    }
}