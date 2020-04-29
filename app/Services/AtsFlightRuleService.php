<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/29/2020
 * Time: 9:03 PM
 */

namespace App\Services;

use App\Models\AtsFlightRule;


class AtsFlightRuleService
{
    public function getAllAtsFlightRule()
    {
        $rules = AtsFlightRule::all();
        return $rules;
    }
}