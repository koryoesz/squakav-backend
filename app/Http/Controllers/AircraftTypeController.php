<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/27/2020
 * Time: 2:10 PM
 */

namespace App\Http\Controllers;

use App\Services\AircraftTypeService;
use App\Components\Response as JsonResponse;

class AircraftTypeController extends Controller
{
    public function __construct()
    {

    }

    public function getAircraftType($codeIataAircraft)
    {
        $type = (new AircraftTypeService())->getAircratType($codeIataAircraft);
        return JsonResponse::success($type);
    }
}