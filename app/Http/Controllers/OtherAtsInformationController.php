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
use App\Services\SystemFlightService;

class OtherAtsInformationController extends Controller
{
    public function getAllOtherInformation()
    {
        $information = (new OtherAtsFlightInformationService())->getAllOtherInformation();
        return JsonResponse::success($information);
    }

    public function test()
    {
        $create = (new SystemFlightService())->save('hello');
        return $create;
    }
}