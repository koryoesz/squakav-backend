<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/27/2020
 * Time: 12:01 AM
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use App\Models\FlightRplDay;

class FlightRplDaysService
{
    public function create($params)
    {
        $prepareParams = $this->prepareAndValidateDays($params);
        return FlightRplDay::create($prepareParams);
    }

    protected function prepareAndValidateDays($params)
    {
        $prepareParams = [
            'monday' => isset($params['monday']) ? $params['monday']: '',
            'tuesday' => isset($params['tuesday']) ? $params['tuesday']: '',
            'wednesday' => isset($params['wednesday']) ? $params['wednesday']: '',
            'thursday' => isset($params['thursday']) ? $params['thursday']: '',
            'friday' => isset($params['friday']) ? $params['friday']: '',
            'saturday' => isset($params['saturday']) ? $params['saturday']: '',
            'sunday' => isset($params['sunday']) ? $params['sunday']: '',

        ];

        $validator = Validator::make($params, [
            'monday' => 'required|bool',
            'tuesday' => 'required|bool',
            'wednesday' => 'required|bool',
            'thursday' => 'required|bool',
            'friday' => 'required|bool',
            'saturday' => 'required|bool',
            'sunday' => 'required|bool',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        return $prepareParams;
    }
}