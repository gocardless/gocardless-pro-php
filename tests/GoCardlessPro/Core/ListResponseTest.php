<?php

namespace GoCardlessPro\Core;

class ListResponseTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->raw_response = new Response(
            '{"test": [{"obj":"hi"}, {"foo": "test"}], "meta": {"limit": 5}}',
            200,
            'text/html'
        );
        $this->raw_response->set_unwrap_json('test');
        $this->response = new ListResponse('\GoCardlessPro\Core\Mocks\ResourceHolder', $this->raw_response);
    }
    public function testModelsUnwrap()
    {
        $records = $this->response->records();
        $this->assertEquals(count($records), 2);
        $this->assertEquals('test', $records[1]->data()->foo);
    }
    public function testModelsIndexing()
    {
        $records = $this->response->records();
        $this->assertNotNull($records[0]);
        $this->assertFalse(isset($records[2]));
        $this->assertTrue(isset($records[1]));
    }
    public function testForeachCount()
    {
        $count = 0;
        $items = array();
        foreach ($this->response->records() as $item) {
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
        $this->assertEquals($this->raw_response->limit(), $this->response->meta()->limit());
    }
}
