<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/1/2020
 * Time: 5:05 PM
 */

namespace App\Services;

use App\Models\WakeTurbulenceCategory;
use Illuminate\Support\Facades\Cache;

class WakeTurbulenceCategoryService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public function getAllWakeTurbulenceCategory()
    {
        $categories = Cache::get('wake_turbulence_category');

        if(empty($categories))
        {
            $categories = WakeTurbulenceCategory::all();
            Cache::put('wake_turbulence_category', $categories, 180000);
        }

        return $categories;
    }
}