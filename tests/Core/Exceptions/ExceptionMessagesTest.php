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

    public function testInvalidStateExecptionMessage()
    {
        $this->setExpectedException('GoCardlessPro\Core\Exception\InvalidStateException',
                                    'Mandate is already active or being submitted');

        $fixture = $this->getFixture('invalid_state_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new InvalidStateException($response);
    }

    public function testInvalidApiUsageMessage()
    {
        $this->setExpectedException('GoCardlessPro\Core\Exception\InvalidApiUsageException',
                                    'Invalid document structure (Root element must be an object.)');

        $fixture = $this->getFixture('invalid_api_usage_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new InvalidApiUsageException($response);
    }

    public function testValidationFailedMessage()
    {
        $this->setExpectedException('GoCardlessPro\Core\Exception\ValidationFailedException',
                                    'Validation failed (branch_code must be a number, country_code is invalid)');

        $fixture = $this->getFixture('validation_failed_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new ValidationFailedException($response);
    }

    public function testValidationFailedWithoutFieldMessage()
    {
        $this->setExpectedException('GoCardlessPro\Core\Exception\ValidationFailedException',
                                    'Validation failed (Bank account already exists)');

        $fixture = $this->getFixture('validation_failed_error_without_field');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new ValidationFailedException($response);
    }

    public function testGoCardlessException()
    {
        $this->setExpectedException('GoCardlessPro\Core\Exception\GoCardlessInternalException',
                                    'Uh-oh!');

        $fixture = $this->getFixture('gocardless_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        throw new GoCardlessInternalException($response);
    }
}
