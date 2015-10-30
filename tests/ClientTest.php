<?php

namespace GoCardlessPro;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testNoEnvironmentCreationFails()
    {
        $this->setExpectedException('Exception', 'Missing required option `environment`.');
        $client = new Client(array('access_token' => 'foo'));
    }

    public function testNoAccessTokenCreationFails()
    {
        $this->setExpectedException('Exception', 'Missing required option `access_token`.');
        $client = new Client(array('environment' => 'live'));
    }

    public function testOnlyStringArguments()
    {
        $this->setExpectedException('Exception', 'Option `access_token` can only be a string.');
        $client = new Client(array('access_token' => array(), 'environment' => 'live'));
    }

    public function testCreatesClientSuccessfully()
    {
        $client = new Client(array('access_token' => 'foo', 'environment' => 'live'));
        $this->assertNotNull($client);
        $this->assertInstanceOf('\GoCardlessPro\Services\CustomersService', $client->customers());
    }
}
