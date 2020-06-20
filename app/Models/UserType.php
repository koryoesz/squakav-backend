<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/27/2020
 * Time: 12:13 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserType extends Model
{
    const TYPE_OPERATOR = 1;
    const TYPE_AIS = 2;
    const TYPE_TOWER = 3;
    const TYPE_ACC = 4;
    const TYPE_ADMIN = 5;

    const LABEL_OPERATOR = 'operator';
    const LABEL_AIS = 'ais';
    const LABEL_TOWER = 'tower';
    const LABEL_ACC = 'acc';
    const LABEL_ADMIN = 'admin';

    public static $type_map = [
        self::LABEL_OPERATOR => self::TYPE_OPERATOR,
        self::LABEL_AIS => self::TYPE_AIS,
        self::LABEL_ACC => self::TYPE_ACC,
        self::LABEL_TOWER => self::TYPE_TOWER,
        self::LABEL_ADMIN => self::TYPE_ADMIN
    ];

    public static $label_map = [
        self::TYPE_OPERATOR => self::LABEL_OPERATOR,
        self::TYPE_AIS => self::LABEL_AIS,
        self::TYPE_ACC => self::LABEL_ACC,
        self::TYPE_TOWER => self::LABEL_TOWER,
        self::LABEL_ADMIN => self::TYPE_ADMIN
    ];

    public static function getClassById($id)
    {
        if(!isset($id)){ return [];}
        $type = self::find($id);
        $class =  empty($type->class) ? [] : $type->class;
        return $class;
    }
}