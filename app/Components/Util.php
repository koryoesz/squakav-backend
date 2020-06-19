<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/18/2020
 * Time: 11:55 AM
 */

namespace App\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use IcyApril\CryptoLib;

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

    public static function generateToken($prefix = '',$identifier  = '' , $max_tries = 5)
    {
        for ($i = 0; $i < $max_tries; $i++){
            $token = $identifier . CryptoLib::randomString(40) . uniqid();

            $data = Cache::get($prefix . $token);
            if (empty($data)){
                return $token;
            }
        }

        return null;
    }

    public static function camelCaseToSnakeCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}