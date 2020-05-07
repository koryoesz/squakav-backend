<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/7/2020
 * Time: 3:31 PM
 */

namespace App\Http\Controllers;

use App\Services\TransponderTypePropertyService;
use App\Components\Response as JsonResponse;

class FlightTransponderTypePropertyController
{
    public function getAllTransponderTypeProperty()
    {
        $properties = (new TransponderTypePropertyService())->getAllTransponderTypeProperty();
        return JsonResponse::success($properties);
    }
}