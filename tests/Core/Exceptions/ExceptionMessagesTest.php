<?php

namespace GoCardlessPro\Core\Exception;

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
        throw new InvalidStateException($fixture->error);
    }

    /**
     * @expectedException        GoCardlessPro\Core\Exception\InvalidApiUsageException
     * @expectedExceptionMessage Invalid document structure (Root element must be an object.)
     */
    public function testInvalidApiUsageMessage()
    {
        $fixture = $this->getFixture('invalid_api_usage_error');
        throw new InvalidApiUsageException($fixture->error);
    }

    /**
     * @expectedException        GoCardlessPro\Core\Exception\ValidationFailedException
     * @expectedExceptionMessage Validation failed (branch_code must be a number, country_code is invalid)
     */
    public function testValidationFailedMessage()
    {
        $fixture = $this->getFixture('validation_failed_error');
        throw new ValidationFailedException($fixture->error);
    }

    /**
     * @expectedException        GoCardlessPro\Core\Exception\ValidationFailedException
     * @expectedExceptionMessage Validation failed (Bank account already exists)
     */
    public function testValidationFailedWithoutFieldMessage()
    {
        $fixture = $this->getFixture('validation_failed_error_without_field');
        throw new ValidationFailedException($fixture->error);
    }

    /**
     * @expectedException        GoCardlessPro\Core\Exception\GoCardlessInternalException
     * @expectedExceptionMessage Uh-oh!
     */
    public function testGoCardlessException()
    {
        $fixture = $this->getFixture('gocardless_error');
        throw new GoCardlessInternalException($fixture->error);
    }
}
