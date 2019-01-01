<?php

namespace App\Api;

use App\Client\ApiClientService;

class StateInfoCallAdapter implements ApiCallAdapterInterface
{
    /**
     * @var ApiClientService
     */
    private $apiClient;

    /**
     * StateInfoCallAdapter constructor.
     */
    public function __construct()
    {
        $this->apiClient = new ApiClientService();
    }

    /**
     * @param  $name
     * @return array
     */
    public function call($name)
    {
        $response = $this->apiClient->makeRequest('GET', 'name', $name);

        return json_decode($response, true);
    }
}