<?php

namespace GoCardlessPro;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testNoApiKeyFails()
    {
        $this->setExpectedException('Exception', 'Missing required option `access_token`.');
        $client = new Client(array());
    }
    public function testUnnecessaryArgumentsExplode()
    {
        $this->setExpectedException('Exception', 'Unexpected options passed in: blahblahblah');
        $client = new Client(array('access_token' => 'sdf', 'blahblahblah' => 'lol'));
    }
    public function testClientSetsProductionDefaultEnvironment()
    {
        $client = new Client(array('access_token' => ''));
        $this->assertEquals(Environment::PRODUCTION, $client->http_client()->base_url());
    }
    public function testClientSetsProperEnvironment()
    {
        $client = new Client(array('access_token' => '', 'environment' => Environment::SANDBOX));
        $this->assertEquals(Environment::SANDBOX, $client->http_client()->base_url());
    }
    public function testNoApiSecretCreationFails()
    {
        $this->setExpectedException('Exception', 'Missing required option `access_token`.');
        $client = new Client(array('environment' => ''));
    }
    public function testOnlyStringArguments()
    {
        $this->setExpectedException('Exception', 'Option `access_token` can only be a string.');
        $client = new Client(array('access_token' => array(), 'environment' => ''));
    }
    public function testCreatesClientSuccessfully()
    {
        $client = new Client(array('access_token' => 'foo', 'environment' => 'blah'));
        $this->assertNotNull($client);
        $this->assertNotNull($client->http_client());
        $this->assertInstanceOf('\GoCardlessPro\Core\HttpClient', $client->http_client());
        $this->assertInstanceOf('\GoCardlessPro\Services\CustomersService', $client->customers());
    }
}
