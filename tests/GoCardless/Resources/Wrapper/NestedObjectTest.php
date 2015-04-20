<?php

namespace GoCardless\Resources\Wrapper;

/**
  * Test the nested object getter helper class
  */
class NestedObjectTest extends \PHPUnit_Framework_TestCase
{
    function testNestedObjectGet()
    {
        $o = new NestedObject('test', (object) array('name' => 'jill'));
        $this->assertEquals('jill', $o->name());
    }

    function testNestedObjectInnerGet()
    {
        $o = new NestedObject('test', (object) array('person' => (object) array('age' => 20)));
        $this->assertEquals(20, $o->person()->age());
    }

    function testNestedObjectArrayGet()
    {
        $json = json_decode('{"numbers": [1,2,3,4]}');
        $o = new NestedObject('test', $json);
        $this->assertEquals(4, count($o->numbers()));
        $this->assertEquals(2, $o->numbers()[1]);
    }
}