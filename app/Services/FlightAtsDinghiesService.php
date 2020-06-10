<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 6/2/2020
 * Time: 3:51 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\FlightAtsJacket;

class FlightAtsDinghiesService
{
    public static function createAtsDinghies($params, $flight_id)
    {
        $prepareParams = self::prepareAndValidateAtsDinghies($params, $flight_id);
        $jacket = DB::table('flight_ats_dinghies')->insert($prepareParams);
    }

    public static function updateAtsDinghies($params, $flight_id)
    {
        $prepareParams = self::prepareAndValidateAtsDinghies($params, $flight_id);

        $jacket = FlightAtsJacket::where('flight_id', $flight_id)->get();
        if($jacket->count() == 0)
        {
            return DB::table('flight_ats_dinghies')->insert($prepareParams);
        }
        
        $jacket[0]->update($prepareParams);
    }

    protected static function prepareAndValidateAtsDinghies()
    {
        $prepareParams = [
            'capacity' => isset($params['capacity']) ? $params['capacity']: '',
            'number' => isset($params['number']) ? $params['number']: '',
            'color' => isset($params['color']) ? $params['color']: '',
            'flight_id' => isset($flight_id) ? $flight_id : ''
        ];

        $validator = Validator::make($params, [
            'capacity' => 'required|numeric|digits:3',
            'number' => 'required|numeric|digits:2',
            'color' => 'required|string|max:15',
        ]);

        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        return $prepareParams;
    }

}