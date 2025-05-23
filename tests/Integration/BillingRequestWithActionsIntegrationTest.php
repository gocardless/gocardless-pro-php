<?php
//
// WARNING: Do not edit by hand, this file was generated by Crank:
// https://github.com/gocardless/crank
//

namespace GoCardlessPro\Integration;

class BillingRequestWithActionsIntegrationTest extends IntegrationTestBase
{
    public function testResourceModelExists()
    {
        $obj = new \GoCardlessPro\Resources\BillingRequestWithAction(array());
        $this->assertNotNull($obj);
    }
    
    public function testBillingRequestWithActionsCreateWithActions()
    {
        $fixture = $this->loadJsonFixture('billing_request_with_actions')->create_with_actions;
        $this->stub_request($fixture);

        $service = $this->client->billingRequestWithActions();
        $response = call_user_func_array(array($service, 'createWithActions'), (array)$fixture->url_params);

        $body = $fixture->body->billing_request_with_actions;
    
        $this->assertInstanceOf('\GoCardlessPro\Resources\BillingRequestWithAction', $response);

        $this->assertEquals($body->bank_authorisations, $response->bank_authorisations);
        $this->assertEquals($body->billing_requests, $response->billing_requests);
    

        $expectedPathRegex = $this->extract_resource_fixture_path_regex($fixture);
        $dispatchedRequest = $this->history[0]['request'];
        $this->assertMatchesRegularExpression($expectedPathRegex, $dispatchedRequest->getUri()->getPath());
    }

    
}
