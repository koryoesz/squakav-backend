<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/29/2020
 * Time: 11:29 PM
 */

namespace App\Http\Controllers;

use App\Services\AtsFlightRuleService;
use App\Components\Response as JsonResponse;

class AtsFlightRuleController
{
    public function getAllAtsFlightRule()
    {
        $rules = (new AtsFlightRuleService())->getAllAtsFlightRule();
        return JsonResponse::success($rules);
    }
}