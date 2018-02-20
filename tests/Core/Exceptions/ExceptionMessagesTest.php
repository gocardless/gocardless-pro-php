<?php

namespace GoCardlessPro\Core\Exception;

use GoCardlessPro\Core\ApiResponse;

class ErrorTest extends \PHPUnit_Framework_TestCase
{

    private function getFixture($name)
    {
        $path = 'tests/fixtures/' . $name . '.json';
        return json_decode(fread(fopen($path, "r"), filesize($path)));
    }

    /**
     * @expectedException        GoCardlessPro\Core\Exception\InvalidStateException
     * @expectedExceptionMessage Mandate is already active or being submitted
     */
    public function testInvalidStateExecptionMessage()
    {
        $fixture = $this->getFixture('invalid_state_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new InvalidStateException($response);
    }

    /**
     * @expectedException        GoCardlessPro\Core\Exception\InvalidApiUsageException
     * @expectedExceptionMessage Invalid document structure (Root element must be an object.)
     */
    public function testInvalidApiUsageMessage()
    {
        $fixture = $this->getFixture('invalid_api_usage_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new InvalidApiUsageException($response);
    }

    /**
     * @expectedException        GoCardlessPro\Core\Exception\ValidationFailedException
     * @expectedExceptionMessage Validation failed (branch_code must be a number, country_code is invalid)
     */
    public function testValidationFailedMessage()
    {
        $fixture = $this->getFixture('validation_failed_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new ValidationFailedException($response);
    }

    /**
     * @expectedException        GoCardlessPro\Core\Exception\ValidationFailedException
     * @expectedExceptionMessage Validation failed (Bank account already exists)
     */
    public function testValidationFailedWithoutFieldMessage()
    {
        $fixture = $this->getFixture('validation_failed_error_without_field');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new ValidationFailedException($response);
    }

    /**
     * @expectedException        GoCardlessPro\Core\Exception\GoCardlessInternalException
     * @expectedExceptionMessage Uh-oh!
     */
    public function testGoCardlessException()
    {
        $fixture = $this->getFixture('gocardless_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new GoCardlessInternalException($response);
    }
}
