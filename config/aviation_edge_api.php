<?php
return [
    // To check aircraft type
    'aircraft_type' => [
        'http_method' => 'GET',
        'url' => 'planeTypeDatabase',
        'query' => [
            'codeIataAircraft' => ['validation' => 'required|integer|max:3']
        ]
    ],
    'airplanes' => [

    ]
];