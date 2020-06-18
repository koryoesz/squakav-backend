<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/15/2020
 * Time: 8:28 PM
 */

namespace App\Services;

use App\Models\UserType;
use App\Models\LocalAuth;
use App\Components\Exception as MyException;
use App\Components\ErrorCode;
use Illuminate\Support\Facades\Validator;
use App\Components\Auth;

class LocalAuthService
{
    public function authenticate($user_type_id, $params)
    {
        $user_class = UserType::getClassById($user_type_id);

        $validation = Validator::make($params, [
            'email' => 'required|email',
            'password' => 'required|string|min:' . LocalAuth::PASSWORD_MIN_LENGTH
        ]);

        if ($validation->fails()){
            throw (new MyException('Invalid input', ErrorCode::INVALID_INPUT))->setData($validation->errors());
        }

        $user = $user_class::getUsingLoginInfo($params);
        if (empty($user)){
            throw new MyException('Invalid credentials provided. Please retry', ErrorCode::INVALID_CRED);
        }

        $local_auth = LocalAuth::active()->where('user_type_id', $user_type_id)->where('user_id', $user->id)->first();
        if (empty($local_auth)){
            throw new MyException('Invalid credentials provided. Please retry', ErrorCode::INVALID_CRED);
        }

        if (!$local_auth->validatePassword($params['password'])){
            throw new MyException('Invalid credentials provided. Please retry', ErrorCode::INVALID_CRED);
        }

        $user_auth = Auth::createNonCached([
            Auth::LABEL_ID => $user->id,
            Auth::LABEL_EMAIL => $user->email,
            Auth::LABEL_TYPE => $user->getType(),
            Auth::LABEL_ROLE => $user->getRole(),
            Auth::LABEL_ORGANISATION_ID => $user->organisation_id
        ]);


        app()->instance('App\Components\Auth', $user_auth);

        $local_auth->updateLoggedInTime();

        app()->forgetInstance('App\Components\Auth');

        return [
            'user' => $user,
            'auth' => $local_auth
        ];

    }
}