<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Aircraft Type route
$router->get('api/aircraftype/{codeIataAircraft}', 'AircraftTypeController@getAircraftType');

// Ats Flight Rule
$router->get('api/ats/flight-rules', 'AtsFlightRuleController@getAllAtsFlightRule');

// get flight types
$router->get('api/flight-types', 'FlightTypeController@getAllFlightType');

// wake turbulence category
$router->get('api/wake-turbulence-category', 'WakeTurbulenceCategoryController@getAllWakeTurbulenceCategory');

// Flight Equipment type
$router->get('api/equipment-types', 'FlightEquipmentTypeController@getAllFlightEquipmentType');

// ATS equipments
$router->get('api/equipments', 'FlightEquipmentController@getAllFlightEquipment');

// Ats transponder
$router->get('api/transponders', 'AtsTransponderController@getFlightAtsTransponder');