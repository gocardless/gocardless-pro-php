<?php

namespace GoCardlessPro;

class WebhookTest extends \PHPUnit_Framework_TestCase
{
    private $request_body = '{"events":[{"id":"EV00BD05S5VM2T","created_at":"2018-07-05T09:13:51.404Z","resource_type":"subscriptions","action":"created","links":{"subscription":"SB0003JJQ2MR06"},"details":{"origin":"api","cause":"subscription_created","description":"Subscription created via the API."},"metadata":{}},{"id":"EV00BD05TB8K63","created_at":"2018-07-05T09:13:56.893Z","resource_type":"mandates","action":"created","links":{"mandate":"MD000AMA19XGEC"},"details":{"origin":"api","cause":"mandate_created","description":"Mandate created via the API."},"metadata":{}}]}';
    private $webhook_endpoint_secret = "ED7D658C-D8EB-4941-948B-3973214F2D49";

    public function testParseWithValidSignature()
    {
        $signature_header = "2693754819d3e32d7e8fcb13c729631f316c6de8dc1cf634d6527f1c07276e7e";

        $events = Webhook::parse($this->request_body, $signature_header, $this->webhook_endpoint_secret);

        $this->assertEquals(count($events), 2);

        $this->assertEquals($events[0]->id, "EV00BD05S5VM2T");
        $this->assertEquals($events[0]->created_at, "2018-07-05T09:13:51.404Z");
        $this->assertEquals($events[0]->resource_type, "subscriptions");
        $this->assertEquals($events[0]->action, "created");
        $this->assertEquals($events[0]->links->subscription, "SB0003JJQ2MR06");
        $this->assertEquals($events[0]->details->origin, "api");
        $this->assertEquals($events[0]->details->cause, "subscription_created");
        $this->assertEquals($events[0]->details->description, "Subscription created via the API.");
        $this->assertEquals($events[0]->metadata, new \stdClass());

        $this->assertEquals($events[1]->id, "EV00BD05TB8K63");
        $this->assertEquals($events[1]->created_at, "2018-07-05T09:13:56.893Z");
        $this->assertEquals($events[1]->resource_type, "mandates");
        $this->assertEquals($events[1]->action, "created");
        $this->assertEquals($events[1]->links->mandate, "MD000AMA19XGEC");
        $this->assertEquals($events[1]->details->origin, "api");
        $this->assertEquals($events[1]->details->cause, "mandate_created");
        $this->assertEquals($events[1]->details->description, "Mandate created via the API.");
        $this->assertEquals($events[1]->metadata, new \stdClass());
    }

    public function testParseWithInvalidSignature()
    {
        $this->setExpectedException('GoCardlessPro\Core\Exception\InvalidSignatureException');

        $signature_header = "not_correct";
        Webhook::parse($this->request_body, $signature_header, $this->webhook_endpoint_secret);
    }

    public function testIsSignatureValidWithValidSignature()
    {
        $signature_header = "2693754819d3e32d7e8fcb13c729631f316c6de8dc1cf634d6527f1c07276e7e";

        $this->assertEquals(Webhook::isSignatureValid($this->request_body, $signature_header, $this->webhook_endpoint_secret), true);
    }

    public function testIsSignatureValidWithInvalidSignature()
    {
        $signature_header = "not_correct";

        $this->assertEquals(Webhook::isSignatureValid($this->request_body, $signature_header, $this->webhook_endpoint_secret), false);
    }
}
