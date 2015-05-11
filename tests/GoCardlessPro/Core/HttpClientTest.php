<?php

namespace GoCardlessPro\Core;

use \GoCardlessPro\Core\Helpers\StaticStorage as StaticStorage;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    
    public function __construct()
    {
        StaticStorage::setup();
        parent::__construct();
    }

    public function tearDown()
    {
        StaticStorage::reset();
    }

    public function setUp()
    {
        $this->client = new \GoCardlessPro\Client(
            array(
                'access_token' => 'ssssh',
                'environment'  => 'https://example.com/'
            )
        );
        $this->http_client = $this->client->http_client();
    }

    public function testIncludedDefaultHeaders()
    {
        $defaultHeaders = $this->http_client->headers();
        // Config Headers
        $this->assertEquals('2015-04-29', $defaultHeaders['GoCardless-Version']);
        
    }

    public function testUrlBaseSet()
    {
        $this->assertEquals('https://example.com/', $this->http_client->base_url());
    }

    public function testMakesProperCurlRequest()
    {
        StaticStorage::setRetVal('curl_exec', '{"thiskey": "hi!"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');

        $request = $this->http_client->make_request('thiskey');
        $response = $request->run('index', 'get', '/', array());

        $this->assertEquals('hi!', $response->response());
        $this->assertEquals(200, $response->status());
        $this->assertEquals('application/json', $response->content_type());
    }

    public function testHandlesProperQueryParameters()
    {
        StaticStorage::setRetVal('curl_exec', '{"thiskey": "hi!"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');

        $request = $this->http_client->make_request('thiskey');
        $response = $request->run('hi', 'get', '/hi', array('age' => '23'));

        $this->assertEquals('https://example.com/hi?age=23', StaticStorage::getOpt(CURLOPT_URL));
    }

    public function testHandlesJoinedQueryParameters()
    {
        StaticStorage::setRetVal('curl_exec', '{"thiskey": "hi!"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');

        $request = $this->http_client->make_request('thiskey');
        $response = $request->run('hi_name', 'get', '/hi?name=jane', array('age' => '23'));

        $this->assertEquals('https://example.com/hi?name=jane&age=23', StaticStorage::getOpt(CURLOPT_URL));
    }
    public function testHandlesAdjacentQueryParams()
    {
        StaticStorage::setRetVal('curl_exec', '{"thiskey": "hi!"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');

        $request = $this->http_client->make_request('thiskey');
        $response = $request->run('hi_name', 'get', '/hi?name=jane', array('age' => '23'));

        $this->assertEquals('https://example.com/hi?name=jane&age=23', StaticStorage::getOpt(CURLOPT_URL));
    }
}
