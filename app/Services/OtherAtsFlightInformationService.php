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
use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param $params
     * @return bool
     */
    public static function createAtsFlightOtherInformation($paramsArray, $flight_id)
    {
        $prepareParams = [];
        foreach ($paramsArray as $param)
        {
            $prepareParams[] = [
                'other_ats_flight_information_id' => isset($param['other_ats_flight_information_id'])
                    ? $param['other_ats_flight_information_id']: '',
                'flight_id' => isset($flight_id) ? $flight_id: '',
                'value' => isset($param['value']) ? $param['value']: '',
            ];

            $validator = Validator::make($param, [
                'other_ats_flight_information_id' => 'required|exists:other_ats_flight_information,id',
                'value' => 'required'
            ]);

            throw_if($validator->fails(), ValidationException::class, $validator->errors());

        }

        $otherInformationProperties = DB::table('flight_ats_other_flight_information')->insert($prepareParams);
    }
}