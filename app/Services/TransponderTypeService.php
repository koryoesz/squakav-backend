<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/7/2020
 * Time: 1:53 PM
 */

namespace App\Services;

use App\Models\TransponderType;
use Illuminate\Support\Facades\Cache;

class TransponderTypeService
{
    public function getAllTransponderType()
    {
        $types = Cache::get('transponder_types');

        if(empty($types))
        {
            $types = TransponderType::all();
            Cache::put('transponder_types', $types);
        }

        return $types;
    }
}