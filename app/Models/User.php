<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 *
 * @property integer $id
 * @property string $email
 */
abstract class User extends BaseModel
{
    public abstract function getRole();
    public abstract function getType();
    public abstract function getTypeName();


    public function getContactInfo($key)
    {
        return (isset($this->$key)) ? $this->$key : null;
    }

}
