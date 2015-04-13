<?php

namespace GoCardless\Core;

use \GoCardless\Core\Helpers\StaticStorage as StaticStorage;

class RequestTest extends \PHPUnit_Framework_TestCase
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
        $this->client = new \GoCardless\Client(array(
          'api_key' => 'hi',
          'api_secret' => 'ssssh',
          'environment' => 'https://example.com/'
        ));
        $this->http_client = $this->client->http_client();
        StaticStorage::setRetVal('exec', '{"thiskey": "hi!"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');
        $this->request = $this->http_client->make_request('thiskey');
    }

    public function testHandlesProperQueryParameters()
    {
        $this->request->run('get', '/hi', array('age' => '23'));
        $this->assertEquals('https://example.com/hi?age=23', StaticStorage::getOpt(CURLOPT_URL));
    }
    public function testHandlesJoinedQueryParameters()
    {
        $this->request->run('get', '/hi?name=jane', array('age' => '23'));
        $this->assertEquals('https://example.com/hi?name=jane&age=23', StaticStorage::getOpt(CURLOPT_URL));
    }
    public function testHandlesMultipleQueryParams()
    {
        $this->request->run('get', '/hi?name=jane&', array('age' => '23'));
        $this->assertEquals('https://example.com/hi?name=jane&age=23', StaticStorage::getOpt(CURLOPT_URL));
    }
    public function testHandlesAdjacentQueryParams()
    {
        $this->request->run('get', '/hi?', array('age' => '23'));
        $this->assertEquals('https://example.com/hi?age=23', StaticStorage::getOpt(CURLOPT_URL));
    }
}
