<?php

namespace GoCardlessPro\Core;

class ApiClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mock = new \GuzzleHttp\Handler\MockHandler();
        $handler = \GuzzleHttp\HandlerStack::create($this->mock);
        $this->history = array();
        $historyMiddleware = \GuzzleHttp\Middleware::history($this->history);
        $handler->push($historyMiddleware);
        $this->mock_http_client = new \GuzzleHttp\Client([
            'handler' => $handler,
            'http_errors' => false
        ]);

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

        $this->api_client->post('/payments', array(
            'params' => array(
                'customers' => array('amount' => '10')
            ),
            'headers' => array(
                'Idempotency-Key' => 'my-custom-idempotency-key'
            )));

        $dispatchedRequest = $this->history[0]['request'];
        $requestIdempotencyKey = $dispatchedRequest->getHeaderLine('Idempotency-Key');
        $this->assertEquals($requestIdempotencyKey, 'my-custom-idempotency-key');
    }

    public function testMergingOfRandomIdempotencyKeyIntoCustomHeadersForPostRequests()
    {
        $data = array("payments" => array("amount" => "10"));
        $body = json_encode($data);
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200, [], $body));

        $this->api_client->post('/payments', array(
            'params' => array(
                'customers' => array('amount' => '10')
            ),
            'headers' => array(
                'My-Custom-Header' => 'foo'
            )));

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

    public function testNon2XXresponse()
    {
        $path = 'tests/fixtures/invalid_state_error.json';
        $body = fread(fopen($path, "r"), filesize($path));
        $this->setExpectedException('GoCardlessPro\Core\Exception\InvalidStateException');

        $this->mock->append(new \GuzzleHttp\Psr7\Response(400, [], $body));
        $this->api_client->get('/some_endpoint');
    }
}
