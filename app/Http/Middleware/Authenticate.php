<?php

namespace App\Http\Middleware;

use Closure;
use App\Components\Auth;
use App\Components\Response as MyResponse;
use App\Components\ErrorCode;
use Illuminate\Http\Request;
use App\Models\UserType;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $user_type, $scope = null)
    {
        $access_token = $request->header('Access-Token');

        if (!empty($access_token)){
            $auth = new Auth($access_token);
            $user_type_list = explode('&', $user_type);

            if ($auth->isLoaded() && (in_array($auth->getTypeName(), $user_type_list)))
            {
                switch ($auth->getType()){
                    case UserType::TYPE_ADMIN:
                    case UserType::TYPE_ACC:
                    case UserType::TYPE_TOWER:
                    case UserType::TYPE_AIS:
                    case UserType::TYPE_OPERATOR:
                    break;
                    default:
                    return MyResponse::error(ErrorCode::ACCESS_DENIED, 'Access Denied.');
                }
                app()->instance('App\Components\Auth', $auth);
                return $next($request);
            }

        }

        return MyResponse::error(ErrorCode::NO_AUTH, 'Access Denied.');

    }
}
