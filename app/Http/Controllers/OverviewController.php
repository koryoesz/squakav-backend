<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 7/22/2020
 * Time: 11:43 PM
 */

namespace App\Http\Controllers;

use App\Components\Auth;
use App\Components\Response as JsonResponse;
use Illuminate\Http\Request;
use App\Services\SystemFlightService;


class OverviewController
{
    public function operatorOverview(Auth $auth)
    {
        $count = (new SystemFlightService())->overview($auth);
        return JsonResponse::success($count);
    }
}