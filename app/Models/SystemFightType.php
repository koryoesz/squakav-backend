<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:02 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemFightType extends Model
{
    protected $table = "system_flight_types";

    const ATS = 1;
    const RPL = 2;

    public static function getClassById($id)
    {
        if(!isset($id)){ return [];}
        $type = self::find($id);
        $class =  empty($type->class) ? [] : $type->class;
        return $class;
    }
}