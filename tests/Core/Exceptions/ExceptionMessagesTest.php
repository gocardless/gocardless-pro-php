<?php

namespace GoCardlessPro\Core\Exception;

use PHPUnit\Framework\TestCase;
use GoCardlessPro\Core\ApiResponse;
use GoCardlessPro\Support\TestFixtures;

class ErrorTest extends TestCase
{
    use TestFixtures;

    public function testInvalidStateExecptionMessage()
    {
        $this->expectException('\GoCardlessPro\Core\Exception\InvalidStateException');
        $this->expectExceptionMessage('Mandate is already active or being submitted');

        $fixture = $this->loadJsonFixture('invalid_state_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new InvalidStateException($response);
    }

    public function testInvalidApiUsageMessage()
    {
        $this->expectException('\GoCardlessPro\Core\Exception\InvalidApiUsageException');
        $this->expectExceptionMessage('Invalid document structure (Root element must be an object.)');

        $fixture = $this->loadJsonFixture('invalid_api_usage_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new InvalidApiUsageException($response);
    }

    public function testValidationFailedMessage()
    {
        $this->expectException('\GoCardlessPro\Core\Exception\ValidationFailedException');
        $this->expectExceptionMessage('Validation failed (branch_code must be a number, country_code is invalid)');

        $fixture = $this->loadJsonFixture('validation_failed_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new ValidationFailedException($response);
    }

    public function testValidationFailedWithoutFieldMessage()
    {
        $this->expectException('\GoCardlessPro\Core\Exception\ValidationFailedException');
        $this->expectExceptionMessage('Validation failed (Bank account already exists)');

        $fixture = $this->loadJsonFixture('validation_failed_error_without_field');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new ValidationFailedException($response);
    }

    public function testGoCardlessException()
    {
        $this->expectException('\GoCardlessPro\Core\Exception\GoCardlessInternalException');
        $this->expectExceptionMessage('Uh-oh!');

        $fixture = $this->loadJsonFixture('gocardless_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new GoCardlessInternalException($response);
    }
}
