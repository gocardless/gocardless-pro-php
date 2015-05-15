<?php
//
// WARNING: Do not edit by hand, this file was generated by Crank:
// https://github.com/gocardless/crank
//

namespace GoCardlessPro\Integration;

class CustomersTest extends IntegrationTestBase
{
    public function setUp()
    {
        $this->clientAndFixtureSetup('customers');
    }

    public function testResourceExists()
    {
        $obj = new \GoCardlessPro\Resources\Customer(null);
        $this->assertNotNull($obj);
    }

    public function testCustomersCreate()
    {
        $fixture = $this->stubResponse('create');

        $func_array = array_values((array) $fixture->url_params);
        $resourceService = $this->client->customers();
        $response = call_user_func_array(array($resourceService, 'create'), $func_array);

        $body = $fixture->body->customers;

    
        $this->assertInstanceOf('\GoCardlessPro\Resources\Customer', $response);

        $this->matchDeepResponse($body->address_line1, $response->address_line1());
        $this->matchDeepResponse($body->address_line2, $response->address_line2());
        $this->matchDeepResponse($body->address_line3, $response->address_line3());
        $this->matchDeepResponse($body->city, $response->city());
        $this->matchDeepResponse($body->country_code, $response->country_code());
        $this->matchDeepResponse($body->created_at, $response->created_at());
        $this->matchDeepResponse($body->email, $response->email());
        $this->matchDeepResponse($body->family_name, $response->family_name());
        $this->matchDeepResponse($body->given_name, $response->given_name());
        $this->matchDeepResponse($body->id, $response->id());
        $this->matchDeepResponse($body->metadata, $response->metadata());
        $this->matchDeepResponse($body->postal_code, $response->postal_code());
        $this->matchDeepResponse($body->region, $response->region());
    

        $this->assertTrue($this->hasCheckedCurl);
    }

    public function testCustomersList()
    {
        $fixture = $this->stubResponse('list');

        $func_array = array_values((array) $fixture->url_params);
        $resourceService = $this->client->customers();
        $response = call_user_func_array(array($resourceService, 'list'), $func_array);

        $body = $fixture->body->customers;

    
        $records = $response->records();
        $this->assertInstanceOf('\GoCardlessPro\Core\ListResponse', $response);
        $this->assertInstanceOf('\GoCardlessPro\Resources\Customer', $records[0]);

        $this->assertEquals($fixture->body->meta->cursors->before, $response->meta()->cursors()->before());
        $this->assertEquals($fixture->body->meta->cursors->after, $response->meta()->cursors()->after());
    

    
        foreach (range(0, count($body) - 1) as $num) {
            $record = $records[$num];
            $this->matchDeepResponse($body[$num]->address_line1, $record->address_line1());
            $this->matchDeepResponse($body[$num]->address_line2, $record->address_line2());
            $this->matchDeepResponse($body[$num]->address_line3, $record->address_line3());
            $this->matchDeepResponse($body[$num]->city, $record->city());
            $this->matchDeepResponse($body[$num]->country_code, $record->country_code());
            $this->matchDeepResponse($body[$num]->created_at, $record->created_at());
            $this->matchDeepResponse($body[$num]->email, $record->email());
            $this->matchDeepResponse($body[$num]->family_name, $record->family_name());
            $this->matchDeepResponse($body[$num]->given_name, $record->given_name());
            $this->matchDeepResponse($body[$num]->id, $record->id());
            $this->matchDeepResponse($body[$num]->metadata, $record->metadata());
            $this->matchDeepResponse($body[$num]->postal_code, $record->postal_code());
            $this->matchDeepResponse($body[$num]->region, $record->region());
            
        }

        $this->assertTrue($this->hasCheckedCurl);
    }

    public function testCustomersGet()
    {
        $fixture = $this->stubResponse('get');

        $func_array = array_values((array) $fixture->url_params);
        $resourceService = $this->client->customers();
        $response = call_user_func_array(array($resourceService, 'get'), $func_array);

        $body = $fixture->body->customers;

    
        $this->assertInstanceOf('\GoCardlessPro\Resources\Customer', $response);

        $this->matchDeepResponse($body->address_line1, $response->address_line1());
        $this->matchDeepResponse($body->address_line2, $response->address_line2());
        $this->matchDeepResponse($body->address_line3, $response->address_line3());
        $this->matchDeepResponse($body->city, $response->city());
        $this->matchDeepResponse($body->country_code, $response->country_code());
        $this->matchDeepResponse($body->created_at, $response->created_at());
        $this->matchDeepResponse($body->email, $response->email());
        $this->matchDeepResponse($body->family_name, $response->family_name());
        $this->matchDeepResponse($body->given_name, $response->given_name());
        $this->matchDeepResponse($body->id, $response->id());
        $this->matchDeepResponse($body->metadata, $response->metadata());
        $this->matchDeepResponse($body->postal_code, $response->postal_code());
        $this->matchDeepResponse($body->region, $response->region());
    

        $this->assertTrue($this->hasCheckedCurl);
    }

    public function testCustomersUpdate()
    {
        $fixture = $this->stubResponse('update');

        $func_array = array_values((array) $fixture->url_params);
        $resourceService = $this->client->customers();
        $response = call_user_func_array(array($resourceService, 'update'), $func_array);

        $body = $fixture->body->customers;

    
        $this->assertInstanceOf('\GoCardlessPro\Resources\Customer', $response);

        $this->matchDeepResponse($body->address_line1, $response->address_line1());
        $this->matchDeepResponse($body->address_line2, $response->address_line2());
        $this->matchDeepResponse($body->address_line3, $response->address_line3());
        $this->matchDeepResponse($body->city, $response->city());
        $this->matchDeepResponse($body->country_code, $response->country_code());
        $this->matchDeepResponse($body->created_at, $response->created_at());
        $this->matchDeepResponse($body->email, $response->email());
        $this->matchDeepResponse($body->family_name, $response->family_name());
        $this->matchDeepResponse($body->given_name, $response->given_name());
        $this->matchDeepResponse($body->id, $response->id());
        $this->matchDeepResponse($body->metadata, $response->metadata());
        $this->matchDeepResponse($body->postal_code, $response->postal_code());
        $this->matchDeepResponse($body->region, $response->region());
    

        $this->assertTrue($this->hasCheckedCurl);
    }
}