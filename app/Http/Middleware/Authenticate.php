<?php

namespace App\Http\Middleware;

use Closure;
use App\Components\Auth;
use App\Components\Response as MyResponse;
use App\Components\ErrorCode;
use Illuminate\Http\Request;

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
    public function handle($request, Closure $next, $scope = null)
    {
        $access_token = $request->header('Access-Token');
        $user_type = $request->route('user_type');
        if (!empty($access_token)){

//            $auth = new Auth($access_token);
            return $next($request);
        }
        app()->instance('App\Components\Auth', null);
        return $next($request);
//        return MyResponse::error(ErrorCode::NO_AUTH, 'Access Denied.');
    }
}
