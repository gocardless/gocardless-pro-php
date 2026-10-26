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
        $this->assertInstanceOf('\GoCardlessPro\Services\CustomersService', $client->customers());
    }

    private function httpClientTimeout(array $config)
    {
        $client = new Client($config + array('access_token' => 'foo', 'environment' => 'live'));

        $api_client_property = new \ReflectionProperty(Client::class, 'api_client');
        $api_client_property->setAccessible(true);
        $api_client = $api_client_property->getValue($client);

        $http_client_property = new \ReflectionProperty($api_client, 'http_client');
        $http_client_property->setAccessible(true);

        return $http_client_property->getValue($api_client)->getConfig('timeout');
    }

    public function testRequestsTimeOutAfter60SecondsByDefault()
    {
        $this->assertSame(60, Client::DEFAULT_TIMEOUT);
        $this->assertSame(60, $this->httpClientTimeout(array()));
    }

    public function testTimeoutCanBeConfigured()
    {
        $this->assertSame(5, $this->httpClientTimeout(array('timeout' => 5)));
    }

    public function testTimeoutCanBeDisabledWithZero()
    {
        $this->assertSame(0, $this->httpClientTimeout(array('timeout' => 0)));
    }
}
