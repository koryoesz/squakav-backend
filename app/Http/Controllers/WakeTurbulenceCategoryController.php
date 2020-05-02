<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/1/2020
 * Time: 6:00 PM
 */

namespace App\Http\Controllers;

use App\Services\WakeTurbulenceCategoryService;
use App\Components\Response as JsonResponse;

class WakeTurbulenceCategoryController
{
    public function getAllWakeTurbulenceCategory()
    {
        $categories = (new WakeTurbulenceCategoryService())->getAllWakeTurbulenceCategory();
        return JsonResponse::success($categories);
    }
}