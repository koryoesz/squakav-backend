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

$router->post('api/auth/local/{user_type}/authenticate', ['uses' => 'AuthController@authenticate']);

$router->group(['prefix' => 'api', 'middleware' => ['auth:operator&ais&tower']] , function () use ($router) {
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
    $router->get('flight/ats/approved', 'FlightAtsController@getAllApproved');
    $router->get('flight/ats/approved/{id}', 'FlightAtsController@getOneApproved');

// System Flights
    $router->get('system-flights', 'SystemFlightController@getAll');
    $router->get('system-flights/sent', 'SystemFlightController@getAllSent');
    $router->get('system-flights/draft', 'SystemFlightController@getAllDraft');
    $router->get('system-flight/types', 'SystemFlightController@types');
    $router->get('system-flights/approved', 'SystemFlightController@getAllApproved');
    $router->get('system-flights/sent/ats', 'SystemFlightController@getAllSentAts');
    $router->get('system-flights/sent/rpl', 'SystemFlightController@getAllSentRpl');
    $router->get('system-flights/get-radio-log-dates', 'SystemFlightController@getRadioLogDates');
    $router->post('system-flights/get-radio-log-dates/flights', 'SystemFlightController@getRadioLogFlights');

// Ais Approve flight
    $router->post('ais/ats/approve', 'AisController@approveAts');
    $router->post('ais/rpl/approve', 'AisController@approveRpl');


// Create Ats Draft
    $router->post('flight/ats/draft', 'FlightAtsController@draft');
    $router->get('flight/ats/draft/{id}', 'FlightAtsController@getOneDraft');

// update Ats draft
    $router->post('flight/ats/draft/update/{flight_id}', 'FlightAtsController@updateDraft');

    // System Airports
    $router->get('system-airports', 'SystemAirportController@getAll');

    // Create, Draft Rpl Flight
    $router->post('flight/rpl/create', 'FlightRplController@create');
    $router->post('flight/rpl/draft', 'FlightRplController@draft');
    $router->post('flight/rpl/draft/update/{flight_id}', 'FlightRplController@updateDraft');

    //View Flight Rpl
    $router->get('flight/rpl/sent', 'FlightRplController@getAllSent');
    $router->get('flight/rpl/sent/{id}', 'FlightRplController@getOneSent');
    $router->get('flight/rpl/draft/{id}', 'FlightRplController@getOneDraft');
    $router->get('flight/rpl/approved', 'FlightRplController@getAllApproved');
    $router->get('flight/rpl/approved/{id}', 'FlightRplController@getOneApproved');


    // logout
    $router->get('auth/logout', 'AuthController@logout');

    // Ais Decline Flight
    $router->post('ais/ats/decline', 'AisController@declineAts');
    $router->post('ais/rpl/decline', 'AisController@declineRpl');

    // operator Overview
    $router->get('operator/overview', 'OverviewController@operatorOverview');
    $router->get('ais/overview', 'OverviewController@aisOverview');

    // Ais Calendar Listing
    $router->post('ais/flights/inbound', 'AisController@getInboundFlights');
    $router->post('ais/flights/outbound', 'AisController@getOutboundFlights');

    // overfly
    $router->post('ais/flights/overfly', 'OverflyController@ais');
});


$router->group(['prefix' => 'api', 'middleware' => ['auth:tower']] , function () use ($router) {
    // Tower
    $router->get('tower/day-to-day/inbound', 'TowerController@getDayToDayListingInbound');
    $router->get('tower/day-to-day/outbound', 'TowerController@getDayToDayListingOutbound');

});

$router->group(['prefix' => 'api', 'middleware' => ['auth:operator&ais&tower&acc']] , function () use ($router) {
    // Get Authenticated User
    $router->get('user', 'UsersController@getUserInfo');
});