<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/23/2020
 * Time: 10:30 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class WakeTurbulenceCategory extends Model
{
  protected $table = "wake_turbulence_category";

  protected $hidden = ['created_at', 'updated_at'];
}