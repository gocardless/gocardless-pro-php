<?php

namespace GoCardless\Resources\Wrapper;

/**
  * Test Various Resources Classes
  */
class NestedArrayTest extends \PHPUnit_Framework_TestCase
{
    function testObjectGet()
    {
        $o = new NestedArray('test', (object) array('name' => 'jill'));
        // A side effect of this implementation - better than only allowing getters.
        $this->assertEquals('jill', $o['name']);
    }

    function testArrayGet()
    {
        $json = json_decode('[1,2,3,4]');
        $o = new NestedArray('test', $json);
        $this->assertEquals(4, count($o));
        $this->assertEquals(3, $o[2]);
    }

    function testNestedArrayGet()
    {
        $json = json_decode('[[1,2,3],1,2,3,4]');
        $o = new NestedArray('test', $json);
        $this->assertEquals(5, count($o));
        $this->assertEquals(2, $o[2]);
        $this->assertEquals(3, count($o[0]));
        $this->assertEquals(1, $o[0][0]);
    }

    function testNestedObjectGet()
    {
        $json = json_decode('[{"age": 20},1,2,3,4]');
        $o = new NestedArray('test', $json);
        $this->assertEquals(5, count($o));
        $this->assertEquals(20, $o[0]->age());
    }

}