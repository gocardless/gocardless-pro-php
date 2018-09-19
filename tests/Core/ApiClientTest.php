<?php

namespace GoCardlessPro\Core;

use GoCardlessPro\Support\TestFixtures;

class ApiClientTest extends \PHPUnit_Framework_TestCase
{
    use TestFixtures;

    public function setUp()
    {
        $this->mock = new \GuzzleHttp\Handler\MockHandler();
        $handler = \GuzzleHttp\HandlerStack::create($this->mock);
        $this->history = array();
        $historyMiddleware = \GuzzleHttp\Middleware::history($this->history);
        $handler->push($historyMiddleware);
        $this->mock_http_client = new \GuzzleHttp\Client(
            [
            'handler' => $handler,
            'http_errors' => false
            ]
        );

        $this->api_client = new ApiClient($this->mock_http_client);
    }

    public function testGetQueryEncoding()
    {
        $query = array("enabled" => true, "customer" => "CU123", "flux_capacitors" => array("enabled" => false));
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200, [], "{}"));
        $this->api_client->get('/some_endpoint', ["query" => $query]);

        $dispatchedRequest = $this->history[0]['request'];
        $this->assertEquals($dispatchedRequest->getUri()->getQuery(), "enabled=true&customer=CU123&flux_capacitors%5Benabled%5D=false");
    }

    public function testSuccessfulResponse()
    {
        $data = array("payments" => array("amount" => "10"));
        $body = json_encode($data);
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200, [], $body));
        $response = $this->api_client->get('/some_endpoint');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($body, $response->getBody());
    }

    public function testRandomIdempotencyKeyInjectionIntoPostRequests()
    {
        $data = array("payments" => array("amount" => "10"));
        $body = json_encode($data);
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200, [], $body));

        $this->api_client->post('/payments', array('params' => array('customers' => array('amount' => '10'))));

        $dispatchedRequest = $this->history[0]['request'];
        $this->assertTrue(array_key_exists('Idempotency-Key', $dispatchedRequest->getHeaders()));
    }

    public function testPreservationOfProvidedIdempotencyKeyForPostRequests()
    {
        $data = array("payments" => array("amount" => "10"));
        $body = json_encode($data);
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200, [], $body));

        $this->api_client->post(
            '/payments', array(
            'params' => array(
                'customers' => array('amount' => '10')
            ),
            'headers' => array(
                'Idempotency-Key' => 'my-custom-idempotency-key'
            ))
        );

            $dispatchedRequest = $this->history[0]['request'];
            $requestIdempotencyKey = $dispatchedRequest->getHeaderLine('Idempotency-Key');
            $this->assertEquals($requestIdempotencyKey, 'my-custom-idempotency-key');
    }

    public function testMergingOfRandomIdempotencyKeyIntoCustomHeadersForPostRequests()
    {
        $data = array("payments" => array("amount" => "10"));
        $body = json_encode($data);
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200, [], $body));

        $this->api_client->post(
            '/payments', array(
            'params' => array(
                'customers' => array('amount' => '10')
            ),
            'headers' => array(
                'My-Custom-Header' => 'foo'
            ))
        );

            $dispatchedRequest = $this->history[0]['request'];
            $requestCustomHeaderValue = $dispatchedRequest->getHeaderLine('My-Custom-Header');
            $this->assertEquals($requestCustomHeaderValue, 'foo');
            $this->assertTrue(array_key_exists('Idempotency-Key', $dispatchedRequest->getHeaders()));
    }

    public function testMalformedResponse()
    {
        $this->setExpectedException(
            'GoCardlessPro\Core\Exception\MalformedResponseException',
            'Malformed response received from server'
        );
        $body = "rubbish non-json response";
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200, [], $body));
        $this->api_client->get('/some_endpoint');
    }

    public function testInvalidStateErrorResponse()
    {
        $fixture = $this->loadFixture('invalid_state_error');
        $this->setExpectedException('GoCardlessPro\Core\Exception\InvalidStateException');

        $this->mock->append(new \GuzzleHttp\Psr7\Response(422, ['Content-Type' => 'application/json'], $fixture));

        try {
            $this->api_client->get('/some_endpoint');
        } catch (\GoCardlessPro\Core\Exception\InvalidStateException $e) {
            $this->assertEquals($e->getApiResponse()->status_code, '422');
            $this->assertEquals($e->getApiResponse()->headers, ['Content-Type' => ['application/json']]);

            throw $e;
        }
    }

    public function testInvalidApiUsageErrorResponse()
    {
        $fixture = $this->loadFixture('invalid_api_usage_error');
        $this->setExpectedException('GoCardlessPro\Core\Exception\InvalidApiUsageException');

        $this->mock->append(new \GuzzleHttp\Psr7\Response(400, ['Content-Type' => 'application/json'], $fixture));

        try {
            $this->api_client->get('/some_endpoint');
        } catch (\GoCardlessPro\Core\Exception\InvalidApiUsageException $e) {
            $this->assertEquals($e->getApiResponse()->status_code, '400');
            $this->assertEquals($e->getApiResponse()->headers, ['Content-Type' => ['application/json']]);

            throw $e;
        }
    }

    public function testValidationFailedErrorResponse()
    {
        $fixture = $this->loadFixture('validation_failed_error');
        $this->setExpectedException('GoCardlessPro\Core\Exception\ValidationFailedException');

        $this->mock->append(new \GuzzleHttp\Psr7\Response(422, ['Content-Type' => 'application/json'], $fixture));

        try {
            $this->api_client->get('/some_endpoint');
        } catch (\GoCardlessPro\Core\Exception\ValidationFailedException $e) {
            $this->assertEquals($e->getApiResponse()->status_code, '422');
            $this->assertEquals($e->getApiResponse()->headers, ['Content-Type' => ['application/json']]);

            throw $e;
        }
    }

    public function testGoCardlessErrorResponse()
    {
        $fixture = $this->loadFixture('gocardless_error');
        $this->setExpectedException('GoCardlessPro\Core\Exception\GoCardlessInternalException');

        $this->mock->append(new \GuzzleHttp\Psr7\Response(500, ['Content-Type' => 'application/json'], $fixture));

        try {
            $this->api_client->get('/some_endpoint');
        } catch (\GoCardlessPro\Core\Exception\GoCardlessInternalException $e) {
            $this->assertEquals($e->getApiResponse()->status_code, '500');
            $this->assertEquals($e->getApiResponse()->headers, ['Content-Type' => ['application/json']]);

            throw $e;
        }
    }
}
