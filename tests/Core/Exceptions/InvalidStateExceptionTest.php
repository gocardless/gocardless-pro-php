<?php

namespace GoCardlessPro\Core\Exception;

class InvalidStateExceptionTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $path = 'tests/fixtures/invalid_state_error.json';
        $fixture = json_decode(fread(fopen($path, "r"), filesize($path)));
        $this->error = new InvalidStateException($fixture->error);
    }

    public function testIsIdempotentCreationConflictForNonConflictError()
    {
        $path = 'tests/fixtures/invalid_state_error.json';
        $fixture = json_decode(fread(fopen($path, "r"), filesize($path)));
        $error = new InvalidStateException($fixture->error);

        $this->assertFalse($error->isIdempotentCreationConflict());
    }

    public function testGetConflictingResourceIdForNonConflictError()
    {
        $path = 'tests/fixtures/invalid_state_error.json';
        $fixture = json_decode(fread(fopen($path, "r"), filesize($path)));
        $error = new InvalidStateException($fixture->error);

        $this->assertNull($error->getConflictingResourceId());
    }

    public function testIsIdempotentCreationConflictForConflictError()
    {
        $path = 'tests/fixtures/idempotent_creation_conflict_invalid_state_error.json';
        $fixture = json_decode(fread(fopen($path, "r"), filesize($path)));
        $error = new InvalidStateException($fixture->error);

        $this->assertTrue($error->isIdempotentCreationConflict());
    }

    public function testGetConflictingResourceIdForConflictError()
    {
        $path = 'tests/fixtures/idempotent_creation_conflict_invalid_state_error.json';
        $fixture = json_decode(fread(fopen($path, "r"), filesize($path)));
        $error = new InvalidStateException($fixture->error);

        $this->assertEquals($error->getConflictingResourceId(), 'ID123');
    }
}
