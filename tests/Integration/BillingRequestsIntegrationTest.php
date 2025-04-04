<?php
//
// WARNING: Do not edit by hand, this file was generated by Crank:
// https://github.com/gocardless/crank
//

namespace GoCardlessPro\Integration;

class BillingRequestsIntegrationTest extends IntegrationTestBase
{
    public function testResourceModelExists()
    {
        $obj = new \GoCardlessPro\Resources\BillingRequest(array());
        $this->assertNotNull($obj);
    }
    
    public function testBillingRequestsCreate()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->create;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'create'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    public function testBillingRequestsCreateWithIdempotencyConflict()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->create;

        $idempotencyConflictResponseFixture = $this->loadFixture('idempotent_creation_conflict_invalid_state_error');

        // The POST request responds with a 409 to our original POST, due to an idempotency conflict
        $this->mock->append(new \GuzzleHttp\Psr7\Response(409, [], $idempotencyConflictResponseFixture));

        // The client makes a second request to fetch the resource that was already
        // created using our idempotency key. It responds with the created resource,
        // which looks just like the response for a successful POST request.
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200, [], json_encode($fixture->body)));

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'create'), (array)$fixture->url_params);
        $body = $fixture->body->billing_requests;

        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
        

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $conflictRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $conflictRequest->getUri()->getPath());
        $getRequest = $this->history[1]['request'];
        $this->assertEquals($getRequest->getUri()->getPath(), '/billing_requests/ID123');
    }
    
    public function testBillingRequestsCollectCustomerDetails()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->collect_customer_details;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'collectCustomerDetails'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsCollectBankAccount()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->collect_bank_account;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'collectBankAccount'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsConfirmPayerDetails()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->confirm_payer_details;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'confirmPayerDetails'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsFulfil()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->fulfil;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'fulfil'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsCancel()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->cancel;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'cancel'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsList()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->list;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'list'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $records = $response->records;
        $this->assertInstanceOf('\GoCardlessPro\Core\ListResponse', $response);
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $records[0]);
        if (!is_null($fixture->body) && property_exists($fixture->body, 'meta') && !is_null($fixture->body->meta)) {
            $this->assertEquals($fixture->body->meta->cursors->before, $response->before);
            $this->assertEquals($fixture->body->meta->cursors->after, $response->after);
        }
    

    
        foreach (range(0, count($body) - 1) as $num) {
            $record = $records[$num];
            
            if (isset($body[$num]->actions)) {
                $this->assertEquals($body[$num]->actions, $record->actions);
            }
            
            if (isset($body[$num]->created_at)) {
                $this->assertEquals($body[$num]->created_at, $record->created_at);
            }
            
            if (isset($body[$num]->fallback_enabled)) {
                $this->assertEquals($body[$num]->fallback_enabled, $record->fallback_enabled);
            }
            
            if (isset($body[$num]->fallback_occurred)) {
                $this->assertEquals($body[$num]->fallback_occurred, $record->fallback_occurred);
            }
            
            if (isset($body[$num]->id)) {
                $this->assertEquals($body[$num]->id, $record->id);
            }
            
            if (isset($body[$num]->instalment_schedule_request)) {
                $this->assertEquals($body[$num]->instalment_schedule_request, $record->instalment_schedule_request);
            }
            
            if (isset($body[$num]->links)) {
                $this->assertEquals($body[$num]->links, $record->links);
            }
            
            if (isset($body[$num]->mandate_request)) {
                $this->assertEquals($body[$num]->mandate_request, $record->mandate_request);
            }
            
            if (isset($body[$num]->metadata)) {
                $this->assertEquals($body[$num]->metadata, $record->metadata);
            }
            
            if (isset($body[$num]->payment_request)) {
                $this->assertEquals($body[$num]->payment_request, $record->payment_request);
            }
            
            if (isset($body[$num]->purpose_code)) {
                $this->assertEquals($body[$num]->purpose_code, $record->purpose_code);
            }
            
            if (isset($body[$num]->resources)) {
                $this->assertEquals($body[$num]->resources, $record->resources);
            }
            
            if (isset($body[$num]->status)) {
                $this->assertEquals($body[$num]->status, $record->status);
            }
            
            if (isset($body[$num]->subscription_request)) {
                $this->assertEquals($body[$num]->subscription_request, $record->subscription_request);
            }
            
        }

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsGet()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->get;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'get'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsNotify()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->notify;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'notify'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsFallback()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->fallback;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'fallback'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsChooseCurrency()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->choose_currency;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'chooseCurrency'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testBillingRequestsSelectInstitution()
    {
        $fixture = $this->loadJsonFixture('billing_requests')->select_institution;
        $this->stub_request($fixture);

        $service = $this->client->billingRequests();
        $response = call_user_func_array(array($service, 'selectInstitution'), (array)$fixture->url_params);

        $body = $fixture->body->billing_requests;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequest', $response);

        $this->assertEquals($body->actions, $response->actions);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->fallback_enabled, $response->fallback_enabled);
        $this->assertEquals($body->fallback_occurred, $response->fallback_occurred);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->instalment_schedule_request, $response->instalment_schedule_request);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate_request, $response->mandate_request);
        $this->assertEquals($body->metadata, $response->metadata);
        $this->assertEquals($body->payment_request, $response->payment_request);
        $this->assertEquals($body->purpose_code, $response->purpose_code);
        $this->assertEquals($body->resources, $response->resources);
        $this->assertEquals($body->status, $response->status);
        $this->assertEquals($body->subscription_request, $response->subscription_request);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
}
