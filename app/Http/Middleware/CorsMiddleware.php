<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/1/2020
 * Time: 1:47 PM
 */

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowedDomains = array("http://localhost:8080", "https://koryoesz.gitlab.io/squakav", "https://koryoesz.gitlab.io");
        $origin = $request->server('HTTP_ORIGIN');
        if(in_array($origin, $allowedDomains)){
            //Intercepts OPTIONS requests
            if($request->isMethod('OPTIONS')) {
                $response = response('', 200);
            } else {
                // Pass the request to the next middleware
                $response = $next($request);
            }
            // Adds headers to the response
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Methods', 'OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
            $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        }

        // Sends it
        return $response;
    }
}