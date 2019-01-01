<?php

namespace Tests\Unit;

use App\Client\ApiClientService;
use GuzzleHttp\Client;

const TEST_BASE_URL = 'https://restcountries.eu/rest/v2/';
const TEST_FULL_TEXT = '?fullText=true';


class ApiClientServiceTest extends \PHPUnit\Framework\TestCase
{

    public function testGetCountryName()
    {
        $http = new Client();
        $name = 'Turkey';
        $actualResult = $http->get(TEST_BASE_URL . 'name/' . $name . TEST_FULL_TEXT, [
            'Accept' => 'Application/json'
        ])->getBody()->getContents();
        $classUnderTest = new ApiClientService();
        $expectedResult = $classUnderTest->makeRequest('GET','name', 'Turkey');
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testGetCountryCode()
    {
        $http = new Client();
        $code = 'tr';
        $actualResult = $http->get(TEST_BASE_URL . 'lang/' . $code,
            [
                'Accept' => 'Application/json'
            ])->getBody()->getContents();
        $classUnderTest = new ApiClientService();
        $expectedResult = $classUnderTest->makeRequest('GET','lang', $code);

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testGetLanguageUrl()
    {
        $code = 'tr';
        $path = 'lang/';
        $type = 'lang';
        $actualResult = TEST_BASE_URL . $path . $code;
        $classUnderTest = new ApiClientService();
        $expectedResult = $classUnderTest->getUrl($type, $code);

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testGetStateNameUrl()
    {
        $name = 'Turkey';
        $path = 'name/';
        $type = 'name';
        $actualResult = TEST_BASE_URL . $path . $name . TEST_FULL_TEXT;
        $classUnderTest = new ApiClientService();
        $expectedResult = $classUnderTest->getUrl($type, $name);
        $this->assertEquals($expectedResult, $actualResult);
    }
}
