<?php

namespace GoCardlessPro;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testNoEnvironmentCreationFails()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Missing required option `environment`.');
        $client = new Client(array('access_token' => 'foo'));
    }

    public function testNoAccessTokenCreationFails()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Missing required option `access_token`.');
        $client = new Client(array('environment' => 'live'));
    }

    public function testOnlyStringArguments()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Option `access_token` can only be a string.');
        $client = new Client(array('access_token' => array(), 'environment' => 'live'));
    }

    public function testCreatesClientSuccessfully()
    {
        $client = new Client(array('access_token' => 'foo', 'environment' => 'live'));
        $this->assertNotNull($client);
        $this->assertInstanceOf('\GoCardlessPro\Services\CustomersService', $client->customers());
    }
}
