<?php

namespace GoCardlessPro\Core\Exception;

class ApiExceptionTest extends \PHPUnit_Framework_TestCase
{
    protected $error;

    protected function setUp()
    {
        $path = 'tests/fixtures/invalid_state_error.json';
        $fixture = json_decode(fread(fopen($path, "r"), filesize($path)));
        $this->error = new InvalidStateException($fixture->error);
    }

    public function testType()
    {
        $this->assertEquals('invalid_state', $this->error->getType());

    }

    public function testCode()
    {
        $this->assertEquals(422, $this->error->getCode());
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
