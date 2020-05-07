<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/7/2020
 * Time: 2:24 PM
 */

namespace App\Http\Controllers;

use App\Services\TransponderTypeService;
use App\Components\Response as JsonResponse;

class FlightTransponderTypeController
{
    public function getAllTransponderType()
    {
        $types = (new TransponderTypeService())->getAllTransponderType();
        return JsonResponse::success($types);
    }
}