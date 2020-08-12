<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/12/2020
 * Time: 10:26 AM
 */

namespace App\Http\Controllers;

use App\Components\Auth;
use App\Components\Response as JsonResponse;
use Illuminate\Http\Request;
use App\Services\OverflyService;
use App\Components\Util;

class OverflyController
{
    public function ais(Request $request, Auth $auth)
    {
        $flights = (new OverflyService())->ais($auth, Util::getRequestBody($request));
        return JsonResponse::success($flights);
    }
}