<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/12/2020
 * Time: 9:42 AM
 */

namespace App\Http\Controllers;

use App\Services\OtherAtsFlightInformationService;
use App\Components\Response as JsonResponse;

class OtherAtsInformationController
{
    public function getAllOtherInformation()
    {
        $information = (new OtherAtsFlightInformationService())->getAllOtherInformation();
        return JsonResponse::success($information);
    }
}