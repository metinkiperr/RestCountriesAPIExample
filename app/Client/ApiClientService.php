<?php

namespace App\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

const BASE_URL = 'https://restcountries.eu/rest/v2/';
const FULL_TEXT = '?fullText=true';

class ApiClientService implements ClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * ApiClientService constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param  $method
     * @param  $endpoint
     * @param  $params
     * @return int|mixed|string
     */
    public function makeRequest($method, $endpoint, $params)
    {
        $url = $this->getUrl($endpoint, $params);

        try {
            return $this->client->request(
                $method, $url, [
                    'Accept' => 'application/json'
                ]
            )->getBody()->getContents();

        } catch (ClientException $e) {
            return $e->getCode();
        }

    }


    /**
     * @param  $path
     * @param  $param
     * @return string
     */
    public function getUrl($path, $param): string
    {
        switch ($path) {
            case 'name':
                return BASE_URL . 'name/' . $param . FULL_TEXT;
                break;
            case 'lang':
                return BASE_URL . 'lang/' . $param;
                break;
            default:
                return false;
                break;
        }
    }
}