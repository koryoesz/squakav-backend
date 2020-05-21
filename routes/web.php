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

// Ats transponders
$router->get('api/transponders', 'AtsTransponderController@getFlightAtsTransponder');

// Transponder types and properties
$router->get('api/transponder-types', 'FlightTransponderTypeController@getAllTransponderType');
$router->get('api/transponder-type-properties', 'FlightTransponderTypePropertyController@getAllTransponderTypeProperty');

// Other Ats Information
$router->get('api/ats-other-information', 'OtherAtsInformationController@getAllOtherInformation');

// Create Ats
$router->post('api/flight/ats/create', 'FlightAtsController@create');

// View sent Ats
$router->get('api/flight/ats/sent', 'FlightAtsController@sentFlights');

// System Flights
$router->get('api/system-flights', 'SystemFlightController@getAll');
$router->get('api/system-flight/types', 'SystemFlightController@types');
