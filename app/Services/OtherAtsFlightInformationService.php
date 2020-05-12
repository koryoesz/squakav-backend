<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/12/2020
 * Time: 7:43 AM
 */

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\OtherAtsFlightInformation;

class OtherAtsFlightInformationService
{
    public function getAllOtherInformation()
    {
        $information = Cache::get('all_ats_other_information');

        if(empty($information))
        {
            $information = OtherAtsFlightInformation::all();
            Cache::put('all_ats_other_information', $information, 18000);
        }

        return $information;
    }
}