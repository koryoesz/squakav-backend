<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/7/2020
 * Time: 5:11 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acc extends User
{
    protected $table = "acc";

    public static function getUsingLoginInfo($params)
    {
        return self::where(function ($query) use ($params){
            $query->where('email', $params['email'])->where('status_id', Status::ACTIVE);
        })->first();
    }

    public function getType()
    {
        return UserType::TYPE_ACC;
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
}