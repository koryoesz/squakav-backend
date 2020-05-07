<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/29/2020
 * Time: 9:03 PM
 */

namespace App\Services;

use App\Models\AtsFlightRule;
use Illuminate\Support\Facades\Cache;


class AtsFlightRuleService
{
    public function getAllAtsFlightRule()
    {
        $rules = Cache::get('ats_flight_rules');

        if(empty($rules))
        {
            $rules = AtsFlightRule::all();
            Cache::put('ats_flight_rules', $rules, 18000);
        }
        return $rules;
    }
}