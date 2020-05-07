<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/7/2020
 * Time: 1:54 PM
 */

namespace App\Services;

use App\Models\TransponderTypeProperty;
use Illuminate\Support\Facades\Cache;

class TransponderTypePropertyService
{
    public function getAllTransponderTypeProperty()
    {
        $properties = Cache::get('transponder_type_properties');

        if(empty($properties))
        {
            $properties = TransponderTypeProperty::all();
            Cache::put('transponder_type_properties', $properties);
        }

        return $properties;
    }
}