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

$router->group(['middleware' => ['auth']] , function () use ($router) {

    $router->post('api/auth/local/{user_type}/authenticate', ['uses' => 'AuthController@authenticate']);
});

$router->group(['prefix' => 'api'] , function () use ($router) {
    // Aircraft Type route
    $router->get('aircraftype/{codeIataAircraft}', 'AircraftTypeController@getAircraftType');

// Ats Flight Rule
    $router->get('ats/flight-rules', 'AtsFlightRuleController@getAllAtsFlightRule');

// get flight types
    $router->get('flight-types', 'FlightTypeController@getAllFlightType');

// wake turbulence category
    $router->get('wake-turbulence-category', 'WakeTurbulenceCategoryController@getAllWakeTurbulenceCategory');

// Flight Equipment type
    $router->get('equipment-types', 'FlightEquipmentTypeController@getAllFlightEquipmentType');

// ATS equipments
    $router->get('equipments', 'FlightEquipmentController@getAllFlightEquipment');

// Ats transponders
    $router->get('transponders', 'AtsTransponderController@getFlightAtsTransponder');

// Transponder types and properties
    $router->get('transponder-types', 'FlightTransponderTypeController@getAllTransponderType');
    $router->get('transponder-type-properties', 'FlightTransponderTypePropertyController@getAllTransponderTypeProperty');

// Other Ats Information
    $router->get('ats-other-information', 'OtherAtsInformationController@getAllOtherInformation');

// Create Ats Flight Plan
    $router->post('flight/ats/create', 'FlightAtsController@create');

// View Flight Ats
    $router->get('flight/ats/sent', 'FlightAtsController@sentFlights');
    $router->get('flight/ats/sent/{id}', 'FlightAtsController@getOneSent');
    $router->get('flight/ats/approved', 'FlightAtsController@approvedFlights');
    $router->get('flight/ats/approved/{id}', 'FlightAtsController@getOneApproved');

// System Flights
    $router->get('system-flights', 'SystemFlightController@getAll');
    $router->get('system-flights/sent', 'SystemFlightController@getAllSent');
    $router->get('system-flights/draft', 'SystemFlightController@getAllDraft');
    $router->get('system-flight/types', 'SystemFlightController@types');

// Ais Approve flight
    $router->post('ais/ats/approve', 'AisController@approve');

// Create Ats Draft
    $router->post('flight/ats/draft', 'FlightAtsController@draft');
    $router->get('flight/ats/draft/{id}', 'FlightAtsController@getOneDraft');

// update Ats draft
    $router->post('flight/ats/draft/update/{flight_id}', 'FlightAtsController@updateDraft');

    // SYstem Airports
    $router->get('system-airports', 'SystemAirportController@getAll');

});