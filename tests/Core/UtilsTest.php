<?php

namespace GoCardlessPro\Core;

class UtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testStringsCanBeBoundAsUrlParameters()
    {
        $this->assertEquals(
            '/me',
            Util::subUrl('/:replace-me', ['replace-me' => 'me'])
        );
    }

    public function testIntegersCanBeBoundAsUrlParameters()
    {
        $this->assertEquals(
            '/1',
            Util::subUrl('/:replace-me', ['replace-me' => 1])
        );
    }

    public function testFloatsCanBeBoundAsUrlParameters()
    {
        $this->assertEquals(
            '/3.14',
            Util::subUrl('/:replace-me', ['replace-me' => (float) 3.14])
        );
    }

    public function testDoublesCanBeBoundAsUrlParameters()
    {
        $this->assertEquals(
            '/3.14',
            Util::subUrl('/:replace-me', ['replace-me' => (double) 3.14])
        );
    }

    public function testToStringObjectsCanBeBoundAsUrlParameters()
    {
        $this->assertEquals(
            '/test',
            Util::subUrl('/:replace-me', ['replace-me' => $this])
        );
    }

    public function testArraysCannotBeBoundAsUrlParameters()
    {
        $this->setExpectedException('Exception');
        Util::subUrl('/:replace-me', ['replace-me' => ['hello' => 'world']]);
    }

    public function testObjectsCannotBeBoundAsUrlParameters()
    {
        $this->setExpectedException('Exception');
        Util::subUrl('/:replace-me', ['replace-me' => (object) ['hello' => 'world']]);
    }

    public function testResourcesCannotBeBoundAsUrlParameters()
    {
        $this->setExpectedException('Exception');
        $stream = fopen('php://stderr', 'r');
        try {
            Util::subUrl('/:replace-me', ['replace-me' => $stream]);
        } finally {
            fclose($stream);
        }
    }

    public function __toString()
    {
        return 'test';
    }
}
