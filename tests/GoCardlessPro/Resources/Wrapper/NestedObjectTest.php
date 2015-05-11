<?php

namespace GoCardlessPro\Resources\Wrapper;

/**
  * Test the nested object getter helper class
  */
class NestedObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testNestedObjectGet()
    {
        $o = new NestedObject('test', (object) array('name' => 'jill'));
        $this->assertEquals('jill', $o->name());
    }

    public function testNestedObjectInnerGet()
    {
        $o = new NestedObject('test', (object) array('person' => (object) array('age' => 20)));
        $this->assertEquals(20, $o->person()->age());
    }

    public function testNestedObjectArrayGet()
    {
        $json = json_decode('{"numbers": [1,2,3,4]}');
        $o = new NestedObject('test', $json);
        $numbers = $o->numbers();
        $this->assertEquals(4, count($numbers));
        $this->assertEquals(2, $numbers[1]);
    }
}
