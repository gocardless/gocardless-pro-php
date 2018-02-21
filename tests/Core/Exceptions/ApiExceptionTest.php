<?php

namespace GoCardlessPro\Core\Exception;

use GoCardlessPro\Core\ApiResponse;
use GoCardlessPro\Support\TestFixtures;

class ApiExceptionTest extends \PHPUnit_Framework_TestCase
{
    use TestFixtures;

    protected $error;

    protected function setUp()
    {
        $fixture = $this->loadJsonFixture('invalid_state_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $this->response = new ApiResponse($raw_response);

        $this->error = new InvalidStateException($this->response);
    }

    public function testType()
    {
        $this->assertEquals('invalid_state', $this->error->getType());

    }

    public function testCode()
    {
        $this->assertEquals(422, $this->error->getCode());
    }

    public function testApiResponse()
    {
        $this->assertEquals($this->response, $this->error->getApiResponse());
    }

    public function testErrors()
    {
        $expected_errors = array(
            (object) array(
                "message" => "Mandate is already active or being submitted",
                "reason" => "mandate_not_inactive"
            )
        );

        $this->assertEquals($expected_errors, $this->error->getErrors());
    }

    public function testDocumentationUrl()
    {
        $this->assertEquals('https://developer.gocardless.com/pro#mandate_not_inactive', $this->error->getDocumentationUrl());
    }

    public function testMessage()
    {
        $this->assertEquals('Mandate is already active or being submitted', $this->error->getMessage());
    }

    public function testRequestId()
    {
        $this->assertEquals('9aac0445-fd1e-4dc2-8854-a5a6afbaaeae', $this->error->getRequestId());
    }
}
