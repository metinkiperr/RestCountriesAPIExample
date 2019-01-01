<?php

namespace App\Api;


interface ApiCallAdapterInterface
{
    /**
     * @param  $param
     * @return array
     */
    public function call($param);
}