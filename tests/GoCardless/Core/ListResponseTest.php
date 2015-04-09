<?php

namespace GoCardless\Core;

class ListResponseTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->raw_response = new Response(
            '{"test": [{"obj":"hi"}, {"foo": "test"}], "meta": {"limit": 5}}',
            200,
            'text/html'
        );
        $this->raw_response->setUnwrapJson('test');
        $this->response = new ListResponse('\GoCardless\Core\Mocks\ResourceHolder', $this->raw_response);
    }
    public function testModelsUnwrap()
    {
        $this->assertEquals(count($this->response), 2);
        $this->assertEquals('test', $this->response[1]->data()->foo);
    }
    public function testModelsIndexing()
    {
        $this->assertNotNull($this->response[0]);
        $this->assertFalse(isset($this->response[2]));
        $this->assertTrue(isset($this->response[1]));
    }
    public function testForeachCount()
    {
        $count = 0;
        $items = array();
        foreach ($this->response as $item) {
            $count++;
            $items[] = $item;
        }
        $this->assertEquals('test', $items[1]->data()->foo);
        $this->assertEquals(2, count($items));
    }
    public function testRawResponse()
    {
        $this->assertEquals($this->raw_response, $this->response->response());
        $this->assertEquals($this->raw_response->meta(), $this->response->meta());
        $this->assertEquals($this->raw_response->limit(), $this->response->meta()->limit);
    }
}
