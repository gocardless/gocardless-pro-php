<?php

namespace GoCardlessPro\Core\Exception;

use GoCardlessPro\Core\ApiResponse;
use GoCardlessPro\Support\TestFixtures;

class InvalidStateExceptionTest extends \PHPUnit_Framework_TestCase
{
    use TestFixtures;

    public function testIsIdempotentCreationConflictForNonConflictError()
    {
        $fixture = $this->loadJsonFixture('invalid_state_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        $error = new InvalidStateException($response);

        $this->assertFalse($error->isIdempotentCreationConflict());
    }

    public function testGetConflictingResourceIdForNonConflictError()
    {
        $fixture = $this->loadJsonFixture('invalid_state_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        $error = new InvalidStateException($response);

        $this->assertNull($error->getConflictingResourceId());
    }

    public function testIsIdempotentCreationConflictForConflictError()
    {
        $fixture = $this->loadJsonFixture('idempotent_creation_conflict_invalid_state_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        $error = new InvalidStateException($response);

        $this->assertTrue($error->isIdempotentCreationConflict());
    }

    public function testGetConflictingResourceIdForConflictError()
    {
        $fixture = $this->loadJsonFixture('idempotent_creation_conflict_invalid_state_error');
        $raw_response = new \GuzzleHttp\Psr7\Response($fixture->error->code, [], json_encode($fixture));
        $response = new ApiResponse($raw_response);
        $error = new InvalidStateException($response);

        $this->assertEquals($error->getConflictingResourceId(), 'ID123');
    }
}
