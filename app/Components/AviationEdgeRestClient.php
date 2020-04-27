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
    protected $api_client_id;

    public function __construct()
    {
        $this->http_client = new Client([
            'base_uri' => env('AVIATION_EDGE_API_BASE_URL')
        ]);
        $this->config = Config::get('aviation_edge_api');
        $this->api_client_id = env('AVIATION_EDGE_API_KEY');
    }

    /**
     * Validates the Param Values based on the API Configuration
     * @param array $api_param_config
     * @param array $params
     * @throws \Throwable
     */
    protected function validateValues($api_param_config, $params)
    {
        $validation_params = [];
        foreach ($api_param_config['params'] as $key => $item){
            $validation_params[$key] = $item['validation'];
        }

        $validator = Validator::make($params, $validation_params);
        throw_if($validator->fails(), ValidationException::class, $validator->errors());
    }

    /**
     * Makes Request to AVIATION EDGE Service
     * @param $api_label
     * @param $params
     * @return array|mixed
     * @throws Exception
     * @throws \Throwable
     */
    public function request($api_label, $params)
    {
        if (empty($this->config[$api_label])){
            throw new CustomException('Could not find configuration', ErrorCode::INTERNAL_ERROR);
        }

        $api_param_config = $this->config[$api_label];
        $this->validateValues($api_param_config, $params);

        try{
            $http_method = strtolower($api_param_config['http_method']);
            $url = $api_param_config['url'];

            $guzzle_params = ['verify' => false];
            if ($http_method == 'get'){
                $guzzle_params['query'] = $params;
            } else {
                $guzzle_params['json'] = $params;
            }

            $response = $this->http_client->$http_method($url, $guzzle_params);

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