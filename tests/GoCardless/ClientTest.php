<?php

namespace GoCardless;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testNoApiKeyFails()
    {
        $this->setExpectedException('Exception', 'Missing required option `api_key`.');
        $client = new Client(array('api_secret' => ''));
    }
    public function testUnnecessaryArgumentsExplode()
    {
        $this->setExpectedException('Exception', 'Unexpected options passed in: blahblahblah');
        $client = new Client(array('api_secret' => '', 'api_key' => 'sdf', 'blahblahblah' => 'lol'));
    }
    public function testClientSetsProductionDefaultEnvironment()
    {
        $client = new Client(array('api_key' => '', 'api_secret' => ''));
        $this->assertEquals(Environment::PRODUCTION, $client->httpClient()->getBaseUrl());
    }
    public function testClientSetsProperEnvironment()
    {
        $client = new Client(array('api_key' => '', 'api_secret' => '', 'environment' => Environment::SANDBOX));
        $this->assertEquals(Environment::SANDBOX, $client->httpClient()->getBaseUrl());
    }
    public function testNoApiSecretCreationFails()
    {
        $this->setExpectedException('Exception', 'Missing required option `api_secret`.');
        $client = new Client(array('api_key' => '', 'environment' => ''));
    }
    public function testOnlyStringArguments()
    {
        $this->setExpectedException('Exception', 'Option `api_key` can only be a string.');
        $client = new Client(array('api_key' => array(), 'api_secret' => '', 'environment' => ''));
    }
    public function testCreatesClientSuccessfully()
    {
        $client = new Client(array('api_key' => 'testing', 'api_secret' => 'foo', 'environment' => 'blah'));
        $this->assertNotNull($client);
        $this->assertNotNull($client->httpClient());
        $this->assertInstanceOf('\GoCardless\Core\HttpClient', $client->httpClient());
        $this->assertInstanceOf('\GoCardless\Services\Customer', $client->customers());
    }
}
