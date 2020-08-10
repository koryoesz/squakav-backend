<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/7/2020
 * Time: 12:55 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Status;
use App\Models\UserType;

class Tower extends User
{
    public static function getUsingLoginInfo($params)
    {
        return self::where(function ($query) use ($params){
            $query->where('email', $params['email'])->where('status_id', Status::ACTIVE);
        })->first();
    }

    public function getType()
    {
        return UserType::TYPE_TOWER;
    }

    public function getRole()
    {
        return $this->role_id;
    }

    public function getTypeName()
    {
        return UserType::LABEL_TOWER;
    }

    public function state()
    {
        return $this->hasOne('App\Models\State', 'id', 'state_id');
    }

    public function airport()
    {
        return $this->hasOne('App\Models\SystemAirport', 'id', 'system_airport_id');
    }
}