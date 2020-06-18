<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/15/2020
 * Time: 7:17 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LocalAuth extends Model
{

    protected $table = "local_auth";

    protected $fillable = ['email', 'password'];

    const PASSWORD_MIN_LENGTH = 5;

    public function scopeActive($query)
    {
        return $query->whereIn('status_id', [Status::ACTIVE]);
    }

    /**
     * Validate password
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Hash::check($password, $this->password);
    }

    public function updateLoggedInTime()
    {
        $this->last_logged_in = DB::raw('NOW()');
        return $this->save();
    }

}