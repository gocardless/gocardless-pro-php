<?php

namespace GoCardless\Core;

require_once(__DIR__ . '/CurlTestHelper.php');

class CurlWrapperRest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        StaticStorage::reset();
    }
    public function testCurlWrapperSetup()
    {
        $wrapper = new CurlWrapper('get', 'http://example.com/');
        $this->assertEquals($wrapper->getOpt(CURLOPT_VERBOSE), false);
        $this->assertGreaterThan(5, $wrapper->getOpt(CURLOPT_TIMEOUT));
        $this->assertEquals('GET', $wrapper->getOpt(CURLOPT_CUSTOMREQUEST));
        $this->assertNull($wrapper->getOpt(CURLOPT_USERPWD));
    }
    public function testCurlDeleteRequest()
    {
        $wrapper = new CurlWrapper('delete', 'http://example.com/resources/2');
        $this->assertEquals('DELETE', $wrapper->getOpt(CURLOPT_CUSTOMREQUEST));
    }
    public function testSetupAuth()
    {
        $wrapper = new CurlWrapper('get', 'http://example.com/');
        $this->assertNull($wrapper->getOpt(CURLOPT_USERPWD));
        $wrapper->setAuth('testing123');
        $this->assertEquals($wrapper->getOpt(CURLOPT_USERPWD), 'testing123');
    }
    public function testPostRequestSetup()
    {
        $wrapper = new CurlWrapper('post', 'http://example.com/');
        $this->assertEquals($wrapper->getOpt(CURLOPT_CUSTOMREQUEST), 'POST');
        $this->assertNull($wrapper->getOpt(CURLOPT_POSTFIELDS));
        $wrapper->setHeaders(array('content-Type' => 'blah/blah'));
        $this->assertEquals($wrapper->getHeader('content-type'), 'blah/blah');
        $wrapper->setPostBody('blahblahblah', 'text/plain');
        $this->assertEquals($wrapper->getHeader('content-type'), 'text/plain');
        $this->assertEquals($wrapper->getOpt(CURLOPT_POSTFIELDS), 'blahblahblah');
    }
    public function testSetupRequest()
    {
        $wrapper = new OpenCurlWrapper('post', 'http://example.com/');
        $wrapper->setHeaders(array('blahHeader' => 'testing'));
        $wrapper->setPostBody('{"company": "gc"}', 'application/json');
        $wrapper->doSetOpt('thisisFoo', 'blah');
        $wrapper->doSetOpt('21', 'blah');
        $wrapper->testSetupRequest();
        $this->assertEquals('blah', StaticStorage::getKey('thisisFoo'));
        $this->assertEquals('POST', StaticStorage::getKey(CURLOPT_CUSTOMREQUEST));
        $headers = StaticStorage::getKey(CURLOPT_HTTPHEADER);
        $this->assertContains('content-type: application/json', $headers);
    }
    public function testCurlFlow()
    {
        StaticStorage::setRetVal('exec', '{"company": "gocardless", "city": "london"}');
        StaticStorage::setRetVal(CURLINFO_HTTP_CODE, 200);
        StaticStorage::setRetVal(CURLINFO_CONTENT_TYPE, 'application/json');

        $wrapper = new OpenCurlWrapper('post', 'http://example.com/');
        $wrapper->run();
        $this->assertEquals(1, StaticStorage::getCalls('curl_init'));
        $this->assertEquals(1, StaticStorage::getCalls('curl_close'));
        $this->assertEquals(1, StaticStorage::getCalls('curl_exec'));
        $this->assertGreaterThan(1, StaticStorage::getCalls('curl_getinfo'));
        $this->assertGreaterThan(4, StaticStorage::getCalls('curl_setopt'));
    }
}
