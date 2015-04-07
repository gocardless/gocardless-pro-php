<?php

namespace GoCardless\Core;

require_once(__DIR__ . '/CurlTestHelper.php');

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    public function tearDown()
    {
        StaticStorage::reset();
    }
    public function setUp()
    {
      $this->client = new \GoCardless\Client(array(
        'api_key' => 'hi',
        'api_secret' => 'ssssh',
        'environment' => 'https://example.com/'
      ));
      $this->httpClient = $this->client->httpClient();
    }
    public function testIncludedDefaultHeaders()
    {
      $defaultHeaders = $this->httpClient->getHeaders();
      // Config Headers
      $this->assertEquals('2014-11-03', $defaultHeaders['GoCardless-Version']);
      
    }
    public function testUrlBaseSet()
    {
      $this->assertEquals('https://example.com/', $this->httpClient->getBaseUrl());
    }
    public function testMakesProperCurlRequest()
    {
        StaticStorage::setRetVal('exec', '{"thiskey": "hi!"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');

        $request = $this->httpClient->makeRequest('thiskey');
        $response = $request->run('get', '/');

        $this->assertEquals('hi!', $response->response());
        $this->assertEquals(200, $response->status());
        $this->assertEquals('application/json', $response->contentType());
      
    }

    public function testHandlesProperQueryParameters()
    {
        StaticStorage::setRetVal('exec', '{"thiskey": "hi!"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');

        $request = $this->httpClient->makeRequest('thiskey');
        $response = $request->run('get', '/hi', array('age' => '23'));

        $this->assertEquals('https://example.com/hi?age=23', StaticStorage::getOpt(CURLOPT_URL));
      
    }

    public function testHandlesJoinedQueryParameters()
    {
        StaticStorage::setRetVal('exec', '{"thiskey": "hi!"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');

        $request = $this->httpClient->makeRequest('thiskey');
        $response = $request->run('get', '/hi?name=jane', array('age' => '23'));

        $this->assertEquals('https://example.com/hi?name=jane&age=23', StaticStorage::getOpt(CURLOPT_URL));
      
    }
    public function testHandlesAdjacentQueryParams()
    {
        StaticStorage::setRetVal('exec', '{"thiskey": "hi!"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');

        $request = $this->httpClient->makeRequest('thiskey');
        $response = $request->run('get', '/hi?name=jane', array('age' => '23'));

        $this->assertEquals('https://example.com/hi?name=jane&age=23', StaticStorage::getOpt(CURLOPT_URL));
      
    }
}
