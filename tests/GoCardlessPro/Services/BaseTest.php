<?php

namespace GoCardlessPro\Services;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    protected $base;

    protected function setUp()
    {
        $this->base = new Mocks\BaseImpl(null);
    }

    public function testEnvelopeKey()
    {
        $this->assertEquals($this->base->envelopeKey(), 'envelopeKey');
    }

    public function testResourceClass()
    {
        $this->assertEquals($this->base->resourceClass(), '\GoCardlessPro\Resources\Customer');
    }

    public function testSubUrlNoChanges()
    {
        $original = 'asdfasdf';
        $this->assertEquals($original, $this->base->proxySubUrl($original, array()));
    }

    public function testSubMultipleChanges()
    {
        $res = $this->base->proxySubUrl('/people/:county/:age', array('county' => 'london', 'age' => '30'));
        $this->assertEquals($res, '/people/london/30');
    }

    public function testSubChangesWrongTypeInt()
    {
        $this->setExpectedException(
            'Exception',
            'URL value for age needs to be a string, not a integer.'
        );
        $res = $this->base->proxySubUrl('/people/:county/:age', array('county' => 'london', 'age' => 30));
        $this->assertEquals($res, '/people/london/30');
    }

    public function testSubChangesWrongTypeObject()
    {
        $this->setExpectedException(
            'Exception',
            'URL value for person needs to be a string, not a object.'
        );
        $res = $this->base->proxySubUrl('/people/:county/:age', array('person' => new \stdClass()));
        $this->assertEquals($res, '/people/london/30');
    }

    public function testMakeRequest()
    {
        $mockClient = $this->getMockBuilder('\GoCardlessPro\Core\HttpClient')
                       ->setMethods(array('make_request'))
                       ->disableOriginalConstructor()
                       ->getMock();


        $mockRequest = $this->getMockBuilder('\GoCardlessPro\Core\Request')
                        ->setMethods(array('run'))
                        ->disableOriginalConstructor()
                        ->getMock();

        $emptyResponse = new \GoCardlessPro\Core\Response(
            '{"envelopeKey": {"name": "iain"}}',
            200,
            'application/json; utf-8'
        );
        $emptyResponse->set_unwrap_json('envelopeKey');

        $mockRequest->expects($this->once())
                ->method('run')
                ->with('post', 'http://example.com/api', array())
                ->willReturn($emptyResponse);

        $mockClient->expects($this->once())
               ->method('make_request')
               ->with($this->equalTo('envelopeKey'))
               ->willReturn($mockRequest);

        $base = new Mocks\BaseImpl($mockClient);

        $response = $base->proxyMakeRequest('post', 'http://example.com/api', array(), array());

        $this->assertInstanceOf('\GoCardlessPro\Resources\Customer', $response);
        $this->assertEquals($response->response(), $emptyResponse);

    }
}
