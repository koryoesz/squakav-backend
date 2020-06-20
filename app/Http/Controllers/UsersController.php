<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/20/2020
 * Time: 8:05 AM
 */

namespace App\Http\Controllers;

use App\Components\Auth;
use App\Components\Response as JsonResponse;
use Illuminate\Http\Request;
use App\Services\UsersService;

class UsersController
{
    public function getUserInfo(Auth $auth)
    {
        $user = (new UsersService())->getUserInfo($auth);
        return JsonResponse::success($user);
    }
}