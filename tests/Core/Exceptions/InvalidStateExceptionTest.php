<?php

namespace GoCardlessPro\Core\Exception;

use GoCardlessPro\Core\ApiResponse;

class InvalidStateExceptionTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $path = 'tests/fixtures/invalid_state_error.json';
        $raw_fixture = fread(fopen($path, "r"), filesize($path));
        $fixture = json_decode($raw_fixture);
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], $raw_fixture);
        $response = new ApiResponse($raw_response);
        $this->error = new InvalidStateException($response);
    }

    public function testIsIdempotentCreationConflictForNonConflictError()
    {
        $path = 'tests/fixtures/invalid_state_error.json';
        $raw_fixture = fread(fopen($path, "r"), filesize($path));
        $fixture = json_decode($raw_fixture);
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], $raw_fixture);
        $response = new ApiResponse($raw_response);
        $error = new InvalidStateException($response);

        $this->assertFalse($error->isIdempotentCreationConflict());
    }

    public function testGetConflictingResourceIdForNonConflictError()
    {
        $path = 'tests/fixtures/invalid_state_error.json';
        $raw_fixture = fread(fopen($path, "r"), filesize($path));
        $fixture = json_decode($raw_fixture);
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], $raw_fixture);
        $response = new ApiResponse($raw_response);
        $error = new InvalidStateException($response);

        $this->assertNull($error->getConflictingResourceId());
    }

    public function testIsIdempotentCreationConflictForConflictError()
    {
        $path = 'tests/fixtures/idempotent_creation_conflict_invalid_state_error.json';
        $raw_fixture = fread(fopen($path, "r"), filesize($path));
        $fixture = json_decode($raw_fixture);
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], $raw_fixture);
        $response = new ApiResponse($raw_response);
        $error = new InvalidStateException($response);

        $this->assertTrue($error->isIdempotentCreationConflict());
    }

    public function testGetConflictingResourceIdForConflictError()
    {
        $path = 'tests/fixtures/idempotent_creation_conflict_invalid_state_error.json';
        $raw_fixture = fread(fopen($path, "r"), filesize($path));
        $fixture = json_decode($raw_fixture);
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], $raw_fixture);
        $response = new ApiResponse($raw_response);
        $error = new InvalidStateException($response);

        $this->assertEquals($error->getConflictingResourceId(), 'ID123');
    }
}
