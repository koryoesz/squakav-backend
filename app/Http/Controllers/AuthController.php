<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/16/2020
 * Time: 11:30 PM
 */

namespace App\Http\Controllers;

use App\Components\Response as JsonResponse;
use Illuminate\Http\Request;
use App\Services\LocalAuthService;
use App\Components\Auth;
use App\Models\User;
use App\Components\Util;

class AuthController extends Controller
{
    public function authenticate(Request $request, $user_type)
    {
        $data = (new LocalAuthService())->authenticate($user_type, Util::getRequestBody($request));

        $auth = Auth::createForUser($data['user'], $data['auth']);

        return JsonResponse::success([
            'user' => $data['user']->toArray(),
            'auth_data' => $auth->getData(),
            'token' => $auth->getToken()
        ]);
    }
}