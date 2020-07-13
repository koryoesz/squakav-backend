<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/20/2020
 * Time: 11:24 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Status;
use App\Models\UserType;

class Ais extends User
{
    protected $table = "ais";

    protected $with = ['state', 'airport'];

    public static function getUsingLoginInfo($params)
    {
        return self::where(function ($query) use ($params){
            $query->where('email', $params['email'])->where('status_id', Status::ACTIVE);
        })->first();
    }

    public function getType()
    {
        return UserType::TYPE_AIS;
    }

    public function getRole()
    {
        return $this->role_id;
    }

    public function getTypeName()
    {
        return UserType::LABEL_AIS;
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