<?php

namespace GoCardless\Core;

class PaginatorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $response = new Response(
            '{"data": [{"domain": ".co.uk"}, {"age": "20"}, {"name": "gocardless"}],
			 "meta": {"cursors": {"before": null, "after": "20"}}, "limit": 40}',
            200,
            'application/json'
        );
        $response->set_unwrap_json('data');
        $responsePage2 = new Response(
            '{"data": [{"domain": ".com"}, {"age": "40"}],
			 "meta": {"cursors": {"before": "10", "after": null}}, "limit": 40}',
            200,
            'application/json'
        );
        $responsePage2->set_unwrap_json('data');
        $this->paginator = new Paginator(new Mocks\TestResource(array(
            '20' => new ListResponse('\GoCardless\Core\Mocks\ResourceHolder', $responsePage2),
            '10' => new ListResponse('\GoCardless\Core\Mocks\ResourceHolder', $response)
        )), 10, new ListResponse('\GoCardless\Core\Mocks\ResourceHolder', $response), array());
    }

    public function testSinglePage()
    {
        $this->assertEquals('.co.uk', $this->paginator->items()[0]->data()->domain);
        $this->assertTrue($this->paginator->nextPage());
        $this->assertTrue($this->paginator->previousPage());
        $this->assertFalse($this->paginator->previousPage());
    }

    public function testTwoPages()
    {
        $this->assertEquals('.co.uk', $this->paginator->items()[0]->data()->domain);
        $this->assertTrue($this->paginator->nextPage());
        $this->assertEquals('.com', $this->paginator->items()[0]->data()->domain);
        $this->assertFalse($this->paginator->nextPage());
        $this->assertEmpty($this->paginator->items());
    }

    public function testForEachIterator()
    {
        $results = array();
        foreach ($this->paginator as $item) {
            $results[] = $item;
        }
        $this->assertFalse($this->paginator->nextPage());
        $this->assertTrue($this->paginator->previousPage());

        $this->assertEquals('.co.uk', $results[0]->data()->domain);
        $this->assertEquals('.com', $results[3]->data()->domain);
        $this->assertEquals('gocardless', $results[2]->data()->name);
        $this->assertEquals(5, count($results));
    }

    public function testMultipleForeach()
    {
        foreach ($this->paginator as $item) {
            // ignore this
        }
        $results = array();
        foreach ($this->paginator as $item) {
            $results[] = $item;
        }
        $this->assertEquals(5, count($results));
        $this->assertEquals('.co.uk', $results[0]->data()->domain);
        $this->assertEquals('.com', $results[3]->data()->domain);
        $this->assertEquals('gocardless', $results[2]->data()->name);

        $this->assertFalse($this->paginator->nextPage());
        $this->assertTrue($this->paginator->previousPage());
    }

    public function testForwardsBackwards()
    {
        $this->paginator->nextPage();
        $this->assertEquals(2, count($this->paginator->items()));
        $this->assertEquals('.com', $this->paginator->items()[0]->data()->domain);
        $this->paginator->previousPage();
        $this->assertEquals(3, count($this->paginator->items()));
        $this->assertEquals('.co.uk', $this->paginator->items()[0]->data()->domain);

    }
}
