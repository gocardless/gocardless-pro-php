<?php

namespace GoCardlessPro\Core;

use GoCardlessPro\Resources\BaseResource;

class FakePaginationResource extends BaseResource
{
    protected $model_name = "FakeResource";
    protected $id;
    protected $name;
}

class PaginatorTest extends \PHPUnit_Framework_TestCase
{
    private function build_list_response($raw_body)
    {
        $raw_response = new \GuzzleHttp\Psr7\Response(200, [], $raw_body);
        $decoded_body = json_decode($raw_body);
        $api_response = new ApiResponse($raw_response);
        $model_class = '\GoCardlessPro\Core\FakePaginationResource';

        return new ListResponse($decoded_body->data, $model_class, $api_response);
    }

    public function setUp()
    {
        $body_1 = '{"data": [{"id": "1", "name": "foo"},{"id":"2", "name":"bar"}], "meta": {"cursors": {"before": null, "after": "3"}}, "limit": 2}';
        $body_2 = '{"data": [{"id": "3", "name": "baz"}], "meta": {"cursors": {"before": "2", "after": null}}, "limit": 2}';

        $fake_service = new Mocks\MockService(
            array(
                $this->build_list_response($body_1),
                $this->build_list_response($body_2)
            )
        );

        $this->paginator = new Paginator($fake_service, array());
    }

    public function testSingleForeachIterator()
    {
        $results = array();
        foreach ($this->paginator as $item) {
            $results[] = $item;
        }

        $this->assertEquals("foo", $results[0]->name);
        $this->assertEquals("bar", $results[1]->name);
        $this->assertEquals("baz", $results[2]->name);
    }

    public function testMultipleIterations()
    {
        $results = array();
        foreach ($this->paginator as $item) {
            $results[] = $item;
        }

        $results = array();
        foreach ($this->paginator as $item) {
            $results[] = $item;
        }

        $this->assertEquals("foo", $results[0]->name);
        $this->assertEquals("bar", $results[1]->name);
        $this->assertEquals("baz", $results[2]->name);
    }
}
