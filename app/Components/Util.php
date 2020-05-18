<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/18/2020
 * Time: 11:55 AM
 */

namespace App\Components;

use Illuminate\Http\Request;

class Util
{
    /**
     * Gets the request body as an array
     * @param Request $request
     * @return array
     */
    public static function getRequestBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data)){
            return [];
        }
        return $data;
    }
}