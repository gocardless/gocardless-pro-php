<?php

namespace GoCardlessPro\Core;

class ApiClientTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->mock = new \GuzzleHttp\Handler\MockHandler();
        $handler = \GuzzleHttp\HandlerStack::create($this->mock);
        $this->mock_http_client = new \GuzzleHttp\Client([
            'handler' => $handler,
            'http_errors' => false
        ]);

        $this->api_client = new ApiClient($this->mock_http_client);
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
