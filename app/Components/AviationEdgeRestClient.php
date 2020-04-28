<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/24/2020
 * Time: 10:10 PM
 */
namespace App\Components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Components\Exception as CustomException;

class AviationEdgeRestClient
{
    /**
     * @var Client
     */
    protected $http_client;

    /**
     * @var array
     */
    protected $config;
    protected $api_key;
    protected $base_uri;

    public function __construct()
    {
        $this->http_client = new Client();
        $this->base_uri = env('AVIATION_EDGE_API_BASE_URL');
        $this->config = Config::get('aviation_edge_api');
        $this->api_key = env('AVIATION_EDGE_API_KEY');
    }

    /**
     * Prepares request uri
     * @param $api_label
     * @param $query
     * @return string
     * @throws Exception
     */
    protected function prepareRequest($api_label, $query)
    {
        $http_url = "";

        if (empty($this->config[$api_label])){
            throw new CustomException('Could not find configuration', ErrorCode::INTERNAL_ERROR);
        }

        $api_param_config = $this->config[$api_label];

        // check if params is an array, meaning bigger than one
        if(is_array($query))
        {
            //
        }
        else{
            $validation_query = ['codeIataAircraft' => $query];
            $this->validateValues($api_param_config, $validation_query);
            $query_key = array_keys($api_param_config['query'])[0];

            $http_url = $this->base_uri.$api_param_config['url'].'?key='.$this->api_key.'&'.$query_key.'='.$query;
        }

        return $http_url;
    }

    /**
     * Validates the Param Values based on the API Configuration
     * @param array $api_param_config
     * @param array $query
     * @throws \Throwable
     */
    protected function validateValues($api_param_config, $query)
    {
        $validation_params = [];
        foreach ($api_param_config['query'] as $key => $item){
            $validation_params[$key] = $item['validation'];
        }

        $validator = Validator::make($query, $validation_params);
        throw_if($validator->fails(), ValidationException::class, $validator->errors());
    }

    /**
     * Makes Request to AVIATION EDGE Service
     * @param $api_label
     * @param $query
     * @return array|mixed
     * @throws Exception
     * @throws \Throwable
     */
    public function request($api_label, $query)
    {
        $uri = $this->prepareRequest($api_label, $query);
        $http_method = $this->config[$api_label]['http_method'];

        try{
            $response = $this->http_client->request($http_method, $uri);
            if (in_array($response->getStatusCode(), [200, 201])){
                return json_decode($response->getBody()->getContents(), true);
            } else if ($response->getStatusCode() == 204) {
                return [];
            }
        }
        catch(RequestException $e)
        {
            $message = ($e instanceof RequestException) ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            return json_decode($message, true);
        }
        catch (\Exception $e)
        {
            throw (new CustomException('An unknown error during the request', ErrorCode::INTERNAL_ERROR));
        }

        throw (new CustomException('Request was not successful. Please try again later', ErrorCode::EXTERNAL_SOURCE_ERROR));
    }
}