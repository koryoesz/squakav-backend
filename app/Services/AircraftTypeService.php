<?php

namespace App\Services;

use App\Components\AviationEdgeRestClient;

class AircraftTypeService
{
    /**
     * @var AviationEdgeRestClient
     */
    protected $rest_client;

    public function __construct()
    {
        $this->rest_client = new AviationEdgeRestClient();
    }

    public function getAircratType($params)
    {
        return $this->rest_client->request('aircraft_type', $params);
    }

}