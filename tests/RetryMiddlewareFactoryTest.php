<?php

namespace GoCardlessPro;

class RetryMiddlewarFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testRetryMiddlewareRetriesGetRequestsWhichTimeout()
    {
        $mock = new \GuzzleHttp\Handler\MockHandler(
            [
            new \GuzzleHttp\Exception\ConnectException('Timeout', new \GuzzleHttp\Psr7\Request('GET', 'test')),
            new \GuzzleHttp\Psr7\Response(200)
            ]
        );

        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $handler->push(RetryMiddlewareFactory::buildMiddleware());
        $history = array();
        $handler->push(\GuzzleHttp\Middleware::history($history));

        $client = new \GuzzleHttp\Client(array('handler' => $handler));

        $this->assertEquals(200, $client->request('GET', '/', array('headers' => array('Idempotency-Key' => 'my-idempotency-key')))->getStatusCode());

        // Retries should keep the same headers (e.g. so idempotency keys get used appropriately)
        $this->assertEquals($history[0]['request']->getHeaders(), $history[1]['request']->getHeaders());
    }

    public function testRetryMiddlewareRetriesGetRequestsWhichRespond5XX()
    {
        $mock = new \GuzzleHttp\Handler\MockHandler(
            [
            new \GuzzleHttp\Psr7\Response(504),
            new \GuzzleHttp\Psr7\Response(200)
            ]
        );

        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $handler->push(RetryMiddlewareFactory::buildMiddleware());

        $client = new \GuzzleHttp\Client(array('handler' => $handler));

        $this->assertEquals(200, $client->request('GET', '/')->getStatusCode());
    }

    public function testRetryMiddlewareRetriesPutRequests()
    {
        $mock = new \GuzzleHttp\Handler\MockHandler(
            [
            new \GuzzleHttp\Exception\ConnectException('Timeout', new \GuzzleHttp\Psr7\Request('PUT', 'test')),
            new \GuzzleHttp\Psr7\Response(200)
            ]
        );

        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $handler->push(RetryMiddlewareFactory::buildMiddleware());

        $client = new \GuzzleHttp\Client(array('handler' => $handler));

        $this->assertEquals(200, $client->request('PUT', '/payments/PM123')->getStatusCode());
    }

    public function testRetryMiddlewareRetriesCreatePostRequests()
    {
        $mock = new \GuzzleHttp\Handler\MockHandler(
            [
            new \GuzzleHttp\Exception\ConnectException('Timeout', new \GuzzleHttp\Psr7\Request('POST', 'test')),
            new \GuzzleHttp\Psr7\Response(200)
            ]
        );

        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $handler->push(RetryMiddlewareFactory::buildMiddleware());

        $client = new \GuzzleHttp\Client(array('handler' => $handler));

        $this->assertEquals(200, $client->request('POST', '/payments')->getStatusCode());
    }

    public function testRetryMiddlewareDoesntRetryActionPostRequests()
    {
        $mock = new \GuzzleHttp\Handler\MockHandler(
            [
            new \GuzzleHttp\Exception\ConnectException('Timeout', new \GuzzleHttp\Psr7\Request('POST', 'test'))
            ]
        );

        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $handler->push(RetryMiddlewareFactory::buildMiddleware());

        $client = new \GuzzleHttp\Client(array('handler' => $handler));

        $this->setExpectedException('\GuzzleHttp\Exception\ConnectException');
        $client->request('POST', '/payments/PM123/actions/cancel');
    }
}
