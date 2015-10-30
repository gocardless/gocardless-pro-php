<?php

namespace GoCardlessPro\Core;

use GoCardlessPro\Core\Exceptions;
use GoCardlessPro\Resources\BaseResource;

class FakeResource extends BaseResource
{
    protected $model_name = "FakeResource";
    protected $id;
    protected $foo;
}

class ListResponseTest extends \PHPUnit_Framework_TestCase
{
    protected $http_response;

    public function setUp()
    {
        $body = '{"data": [{"id":"1", "foo":"hi"}, {"id": "2", "foo": "test"}], "meta": {"limit": 5, "cursors": {"before":"", "after": "3"}}}';
        $raw_response = new \GuzzleHttp\Psr7\Response(200, [], $body);

        $decoded_body = json_decode($body, true);
        $api_response = new ApiResponse($raw_response);
        $model_class = 'GoCardlessPro\Core\FakeResource';

        $this->list_response = new ListResponse($decoded_body['data'], $model_class, $api_response);
    }

    public function testModelsUnwrap()
    {
        $records = $this->list_response->records;
        $this->assertEquals(count($records), 2);
        $this->assertEquals('test', $records[1]->foo);
    }

    public function testModelsIndexing()
    {
        $records = $this->list_response->records;
        $this->assertNotNull($records[0]);
        $this->assertTrue(isset($records[1]));
        $this->assertFalse(isset($records[2]));
    }

    public function testForeachCount()
    {
        $count = 0;
        $items = array();
        foreach ($this->list_response->records as $item) {
            $count++;
            $items[] = $item;
        }
        $this->assertEquals('test', $items[1]->foo);
        $this->assertEquals(2, count($items));
    }
}
