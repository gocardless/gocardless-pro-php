<?php
//
// WARNING: Do not edit by hand, this file was generated by Crank:
// https://github.com/gocardless/crank
//

namespace GoCardlessPro\Integration;

class InstitutionsIntegrationTest extends IntegrationTestBase
{
    public function testResourceModelExists()
    {
        $obj = new \GoCardlessPro\Resources\Institution(array());
        $this->assertNotNull($obj);
    }
    
    public function testInstitutionsList()
    {
        $fixture = $this->loadJsonFixture('institutions')->list;
        $this->stub_request($fixture);

        $service = $this->client->institutions();
        $response = call_user_func_array(array($service, 'list'), (array)$fixture->url_params);

        $body = $fixture->body->institutions;
    
        $records = $response->records;
        $this->assertInstanceOf('\GoCardlessPro\Core\ListResponse', $response);
        $this->assertInstanceOf('\GoCardlessPro\Resources\Institution', $records[0]);
        if (!is_null($fixture->body) && property_exists($fixture->body, 'meta') && !is_null($fixture->body->meta)) {
            $this->assertEquals($fixture->body->meta->cursors->before, $response->before);
            $this->assertEquals($fixture->body->meta->cursors->after, $response->after);
        }
    

    
        foreach (range(0, count($body) - 1) as $num) {
            $record = $records[$num];
            
            if (isset($body[$num]->bank_redirect)) {
                $this->assertEquals($body[$num]->bank_redirect, $record->bank_redirect);
            }
            
            if (isset($body[$num]->country_code)) {
                $this->assertEquals($body[$num]->country_code, $record->country_code);
            }
            
            if (isset($body[$num]->icon_url)) {
                $this->assertEquals($body[$num]->icon_url, $record->icon_url);
            }
            
            if (isset($body[$num]->id)) {
                $this->assertEquals($body[$num]->id, $record->id);
            }
            
            if (isset($body[$num]->logo_url)) {
                $this->assertEquals($body[$num]->logo_url, $record->logo_url);
            }
            
            if (isset($body[$num]->name)) {
                $this->assertEquals($body[$num]->name, $record->name);
            }
            
        }

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testInstitutionsListForBillingRequest()
    {
        $fixture = $this->loadJsonFixture('institutions')->list_for_billing_request;
        $this->stub_request($fixture);

        $service = $this->client->institutions();
        $response = call_user_func_array(array($service, 'listForBillingRequest'), (array)$fixture->url_params);

        $body = $fixture->body->institutions;
    
        $records = $response->records;
        $this->assertInstanceOf('\GoCardlessPro\Core\ListResponse', $response);
        $this->assertInstanceOf('\GoCardlessPro\Resources\Institution', $records[0]);
        if (!is_null($fixture->body) && property_exists($fixture->body, 'meta') && !is_null($fixture->body->meta)) {
            $this->assertEquals($fixture->body->meta->cursors->before, $response->before);
            $this->assertEquals($fixture->body->meta->cursors->after, $response->after);
        }
    

    
        foreach (range(0, count($body) - 1) as $num) {
            $record = $records[$num];
            
            if (isset($body[$num]->bank_redirect)) {
                $this->assertEquals($body[$num]->bank_redirect, $record->bank_redirect);
            }
            
            if (isset($body[$num]->country_code)) {
                $this->assertEquals($body[$num]->country_code, $record->country_code);
            }
            
            if (isset($body[$num]->icon_url)) {
                $this->assertEquals($body[$num]->icon_url, $record->icon_url);
            }
            
            if (isset($body[$num]->id)) {
                $this->assertEquals($body[$num]->id, $record->id);
            }
            
            if (isset($body[$num]->logo_url)) {
                $this->assertEquals($body[$num]->logo_url, $record->logo_url);
            }
            
            if (isset($body[$num]->name)) {
                $this->assertEquals($body[$num]->name, $record->name);
            }
            
        }

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
}
