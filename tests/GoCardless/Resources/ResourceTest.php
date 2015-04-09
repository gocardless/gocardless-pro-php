<?php

namespace GoCardless\Resources;

/**
  * Test Various Resources Classes
  */
class ResourceTest extends \PHPUnit_Framework_TestCase
{
    public function testOptionalResponse()
    {
        $resource = new Customer((object) array('given_name' => 'iain'));

        $this->assertEquals('iain', $resource->givenName());
    }

    public function testRequiredData()
    {
        $this->setExpectedException('Exception', 'Data cannot be null');

        $resource = new Customer(null);
    }

    public function testInvalidGetter()
    {
        $resource = new Customer((object) array('blah' => 'foo'));

        $this->assertFalse(method_exists($resource, 'blah'));
    }

    public function testValidGetter()
    {
        $resource = new Customer((object) array('given_name' => 'notbad'));

        $this->assertEquals('notbad', $resource->givenName());
    }

    public function testRequestNotOverridden()
    {
        $mockResponse = $this->getMockBuilder('\GoCardless\Core\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $resource = new Customer((object) array('response' => 'hi'), $mockResponse);

        $this->assertEquals($mockResponse, $resource->response());
    }

    public function testGetResponse()
    {

        $mockResponse = $this->getMockBuilder('\GoCardless\Core\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $resource = new Customer((object) array(), $mockResponse);

        $this->assertEquals($mockResponse, $resource->response());
    }
}
