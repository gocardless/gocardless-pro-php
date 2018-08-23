<?php

namespace GoCardlessPro\Resources;

class FakeResource extends BaseResource
{
    protected $model_name = "FakeResource";

    protected $foo;
    protected $bar;
    protected $links;
}

/**
 * Test Various Resources Classes
 */
class ResourceTest extends \PHPUnit_Framework_TestCase
{
    public function testValidGetter()
    {
        $resource = new FakeResource((object) array('foo' => 'bar'));

        $this->assertEquals('bar', $resource->foo);
    }

    public function testValidNestedGetter()
    {
        $fake_data = (object) array("links" => (object) array("one" => 1));
        $resource = new FakeResource($fake_data);

        $this->assertEquals(1, $resource->links->one);
    }

    public function testInvalidGetter()
    {
        $this->setExpectedException(
            'GoCardlessPro\Core\Exception\GoCardlessProException',
            'unknown is not a valid FakeResource property'
        );

        $resource = new FakeResource((object) array('foo' => 'bar'));
        $resource->unknown;
    }

    public function testGetApiResponse()
    {
        $mockResponse = $this
            ->getMockBuilder('\GoCardlessPro\Core\ApiResponse')
            ->disableOriginalConstructor()
            ->getMock();
        $resource = new FakeResource((object) array('foo' => 'bar'), $mockResponse);
        $this->assertEquals($mockResponse, $resource->api_response);
    }
}
