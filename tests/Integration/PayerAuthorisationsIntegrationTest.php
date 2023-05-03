<?php
//
// WARNING: Do not edit by hand, this file was generated by Crank:
// https://github.com/gocardless/crank
//

namespace GoCardlessPro\Integration;

class PayerAuthorisationsIntegrationTest extends IntegrationTestBase
{
    public function testResourceModelExists()
    {
        $obj = new \GoCardlessPro\Resources\PayerAuthorisation(array());
        $this->assertNotNull($obj);
    }
    
    public function testPayerAuthorisationsGet()
    {
        $fixture = $this->loadJsonFixture('payer_authorisations')->get;
        $this->stub_request($fixture);

        $service = $this->client->payerAuthorisations();
        $response = call_user_func_array(array($service, 'get'), (array)$fixture->url_params);

        $body = $fixture->body->payer_authorisations;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\PayerAuthorisation', $response);

        $this->assertEquals($body->bank_account, $response->bank_account);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->customer, $response->customer);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->incomplete_fields, $response->incomplete_fields);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate, $response->mandate);
        $this->assertEquals($body->status, $response->status);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testPayerAuthorisationsCreate()
    {
        $fixture = $this->loadJsonFixture('payer_authorisations')->create;
        $this->stub_request($fixture);

        $service = $this->client->payerAuthorisations();
        $response = call_user_func_array(array($service, 'create'), (array)$fixture->url_params);

        $body = $fixture->body->payer_authorisations;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\PayerAuthorisation', $response);

        $this->assertEquals($body->bank_account, $response->bank_account);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->customer, $response->customer);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->incomplete_fields, $response->incomplete_fields);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate, $response->mandate);
        $this->assertEquals($body->status, $response->status);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    public function testPayerAuthorisationsCreateWithIdempotencyConflict()
    {
        $fixture = $this->loadJsonFixture('payer_authorisations')->create;

        $idempotencyConflictResponseFixture = $this->loadFixture('idempotent_creation_conflict_invalid_state_error');

        // The POST request responds with a 409 to our original POST, due to an idempotency conflict
        $this->mock->append(new \GuzzleHttp\Psr7\Response(409, [], $idempotencyConflictResponseFixture));

        // The client makes a second request to fetch the resource that was already
        // created using our idempotency key. It responds with the created resource,
        // which looks just like the response for a successful POST request.
        $this->mock->append(new \GuzzleHttp\Psr7\Response(200, [], json_encode($fixture->body)));

        $service = $this->client->payerAuthorisations();
        $response = call_user_func_array(array($service, 'create'), (array)$fixture->url_params);
        $body = $fixture->body->payer_authorisations;

        $this->assertInstanceOf('\GoCardlessPro\Resources\PayerAuthorisation', $response);

        $this->assertEquals($body->bank_account, $response->bank_account);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->customer, $response->customer);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->incomplete_fields, $response->incomplete_fields);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate, $response->mandate);
        $this->assertEquals($body->status, $response->status);
        

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $conflictRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $conflictRequest->getUri()->getPath());
        $getRequest = $this->history[1]['request'];
        $this->assertEquals($getRequest->getUri()->getPath(), '/payer_authorisations/ID123');
    }
    
    public function testPayerAuthorisationsUpdate()
    {
        $fixture = $this->loadJsonFixture('payer_authorisations')->update;
        $this->stub_request($fixture);

        $service = $this->client->payerAuthorisations();
        $response = call_user_func_array(array($service, 'update'), (array)$fixture->url_params);

        $body = $fixture->body->payer_authorisations;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\PayerAuthorisation', $response);

        $this->assertEquals($body->bank_account, $response->bank_account);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->customer, $response->customer);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->incomplete_fields, $response->incomplete_fields);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate, $response->mandate);
        $this->assertEquals($body->status, $response->status);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testPayerAuthorisationsSubmit()
    {
        $fixture = $this->loadJsonFixture('payer_authorisations')->submit;
        $this->stub_request($fixture);

        $service = $this->client->payerAuthorisations();
        $response = call_user_func_array(array($service, 'submit'), (array)$fixture->url_params);

        $body = $fixture->body->payer_authorisations;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\PayerAuthorisation', $response);

        $this->assertEquals($body->bank_account, $response->bank_account);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->customer, $response->customer);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->incomplete_fields, $response->incomplete_fields);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate, $response->mandate);
        $this->assertEquals($body->status, $response->status);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
    public function testPayerAuthorisationsConfirm()
    {
        $fixture = $this->loadJsonFixture('payer_authorisations')->confirm;
        $this->stub_request($fixture);

        $service = $this->client->payerAuthorisations();
        $response = call_user_func_array(array($service, 'confirm'), (array)$fixture->url_params);

        $body = $fixture->body->payer_authorisations;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\PayerAuthorisation', $response);

        $this->assertEquals($body->bank_account, $response->bank_account);
        $this->assertEquals($body->created_at, $response->created_at);
        $this->assertEquals($body->customer, $response->customer);
        $this->assertEquals($body->id, $response->id);
        $this->assertEquals($body->incomplete_fields, $response->incomplete_fields);
        $this->assertEquals($body->links, $response->links);
        $this->assertEquals($body->mandate, $response->mandate);
        $this->assertEquals($body->status, $response->status);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
}
