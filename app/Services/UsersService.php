<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/20/2020
 * Time: 7:55 AM
 */

namespace App\Services;

use App\Components\Auth;
use App\Models\UserType;
use App\Components\Response as MyResponse;
use App\Components\ErrorCode;

class UsersService
{
    public function getUserInfo(Auth $auth)
    {
        if(!empty($auth))
        {
            $class_user = UserType::getClassById($auth->getType());
            $user = $class_user::find($auth->getId());

            return $user;
        }

        return MyResponse::error(ErrorCode::NO_AUTH, 'Access Denied.');
    }
}