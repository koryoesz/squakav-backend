<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/18/2020
 * Time: 1:12 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Status;
use App\Models\UserType;

class Operator extends User
{
    protected $table = "operators";

    protected $with = ['state', 'organisation'];

    public static function getUsingLoginInfo($params)
    {
        return self::where(function ($query) use ($params){
            $query->where('email', $params['email'])->where('status_id', Status::ACTIVE);
        })->first();
    }

    public function getType()
    {
        return UserType::TYPE_OPERATOR;
    }

    public function getRole()
    {
        return $this->role_id;
    }

    public function getTypeName()
    {
        return UserType::LABEL_OPERATOR;
    }

    public function state()
    {
        return $this->hasOne('App\Models\State', 'id', 'state_id');
    }

    public function organisation()
    {
        return $this->hasOne('App\Models\Organisation', 'id', 'organisation_id');
    }

    public function airport()
    {
        return $this->hasOne('App\Models\OperatorAirport', 'operator_id');
    }
}