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
    public function getUserInfo(Auth $auth, $url_query = "")
    {
        if(!empty($auth))
        {
            $class_user = UserType::getClassById($auth->getType());

            if($auth->getType() == UserType::TYPE_OPERATOR){
                $data =  $class_user::with('airport.system_airport')->where('id', $auth->getId())->get();
                $icao_code = $data[0]->airport->system_airport->icao_code;
                unset($data[0]->airport);
                unset($data[0]->airport->system_airport_id);
                $data[0]->airport->icao_code = $icao_code;
                return $data[0];
            }

            $user = $class_user::find($auth->getId());
            return $user;
        }

        return MyResponse::error(ErrorCode::NO_AUTH, 'Access Denied.');
    }
}