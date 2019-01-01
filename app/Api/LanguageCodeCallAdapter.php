<?php

namespace App\Api;

use App\Client\ApiClientService;

class LanguageCodeCallAdapter implements ApiCallAdapterInterface
{
    /**
     * @var $apiClient
     */
    private $apiClient;

    /**
     * LanguageCodeCallAdapter constructor.
     */
    public function __construct()
    {
        $this->apiClient = new ApiClientService();
    }

    /**
     * @param  $code
     * @return array
     */
    public function call($code): array
    {
        $response = $this->apiClient->makeRequest('GET', 'lang', $code);

        return json_decode($response, true);
    }

}