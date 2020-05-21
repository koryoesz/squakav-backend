<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/13/2020
 * Time: 2:08 PM
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Components\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\SystemFlight;
use Illuminate\Support\Facades\Config;

class SystemFlightService
{

    protected $system_flight;

    public function __construct()
    {
        $this->system_flight = Config::get('constant_system_flight_type');
    }
    /**
     * @param $params
     */

    public static function save($params)
    {
        $validator = Validator::make($params, [
            'flight_id' => 'numeric',
            'system_flight_types_id' => 'numeric',

        ]);
        throw_if($validator->fails(), ValidationException::class, $validator->errors());

        $system_flight = DB::table('system_flights')->insert($params);
    }

    public function getAll()
    {
        $system_flight = SystemFlight::all();
        return $system_flight;
    }

    public function types()
    {
        if(isset($this->system_flight))
        {
            return $this->system_flight;
        }
        return [];
    }
}