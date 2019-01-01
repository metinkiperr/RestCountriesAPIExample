<?php

namespace App\Client;


interface ClientInterface
{
    public function makeRequest($method, $endpoint, $param);

    public function getUrl($path, $param);
}