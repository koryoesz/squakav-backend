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
use Illuminate\Http\Request;

class AisController extends Controller
{

    public function approve(Request $request)
    {
        $response = (new FlightAtsService())->approve(1, $request->all());
        return JsonResponse::success($response);
    }
}