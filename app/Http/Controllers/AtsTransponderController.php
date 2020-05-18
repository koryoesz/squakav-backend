<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/5/2020
 * Time: 3:03 PM
 */

namespace App\Http\Controllers;

use App\Services\AtsTransponderService;
use App\Components\Response as JsonResponse;

class AtsTransponderController extends Controller
{
    public function getFlightAtsTransponder()
    {
        $transponders = (new AtsTransponderService())->getFlightAtsTransponder();
        return JsonResponse::success($transponders);
    }
}