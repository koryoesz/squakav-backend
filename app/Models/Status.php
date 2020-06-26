<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const ACTIVE = 1;
    const INACTIVE = 2;
    const REMOVED = 3;
    const APPROVED = 4;
    const DECLINED = 5;
    const DRAFTED = 6;
    const RESENT = 7;

    protected $table = "status";

}
