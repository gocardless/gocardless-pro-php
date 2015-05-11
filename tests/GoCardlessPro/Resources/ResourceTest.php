<?php

namespace GoCardlessPro\Resources;

/**
  * Test Various Resources Classes
  */
class ResourceTest extends \PHPUnit_Framework_TestCase
{
    public function testOptionalResponse()
    {
        $resource = new Customer((object) array('given_name' => 'iain'));

        $this->assertEquals('iain', $resource->given_name());
    }

    public function testRequiredData()
    {
        $resource = new Customer(null);
        $this->assertNull($resource->family_name());
    }

    public function testInvalidGetter()
    {
        $resource = new Customer((object) array('blah' => 'foo'));

        $this->assertFalse(method_exists($resource, 'blah'));
    }

    public function testValidGetter()
    {
        $resource = new Customer((object) array('given_name' => 'notbad'));

        $this->assertEquals('notbad', $resource->given_name());
    }

    public function testRequestNotOverridden()
    {
        $mockResponse = $this->getMockBuilder('\GoCardlessPro\Core\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $resource = new Customer((object) array('response' => 'hi'), $mockResponse);

        $this->assertEquals($mockResponse, $resource->response());
    }

    public function testGetResponse()
    {

        $mockResponse = $this->getMockBuilder('\GoCardlessPro\Core\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $resource = new Customer((object) array(), $mockResponse);

        $this->assertEquals($mockResponse, $resource->response());
    }
}
