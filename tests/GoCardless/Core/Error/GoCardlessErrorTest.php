<?php

namespace GoCardless\Core\Error;

class GoCardlessErrorTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    private static $error_jsons = array(
        'invalid_api_usage' => '
            {
              "error": {
                "message": "Invalid document structure",
                "documentation_url": "https://developer.gocardless.com/pro#invalid_document_structure",
                "type": "invalid_api_usage",
                "request_id": "bd271b37-a2f5-47c8-b461-040dfe0e9cb1",
                "code": 400,
                "errors": [
                  {
                    "reason": "invalid_document_structure",
                    "message": "Invalid document structure"
                  }
                ]
              }
            }
        ',
        'validation_failed' => '
            {
              "error": {
                "message": "Bank account already exists",
                "documentation_url": "https://developer.gocardless.com/pro#bank_account_exists",
                "type": "validation_failed",
                "request_id": "bd271b37-a2f5-47c8-b461-040dfe0e9cb1",
                "code": 409,
                "errors": [
                  {
                    "reason": "bank_account_exists",
                    "message": "Bank account already exists",
                    "links": {
                      "creditor_bank_account": "BA123"
                    }
                  }
                ]
              }
            }
        ',
        'invalid_state' => '
            {
              "error": {
                "message": "Bank account already exists",
                "documentation_url": "https://developer.gocardless.com/pro#invalid_state_error",
                "type": "invalid_state",
                "request_id": "bd271b37-a2f5-47c8-b461-040dfe0e9cb1",
                "code": 410,
                "errors": [
                  {
                    "reason": "bank_account_cannot_delete",
                    "message": "Bank account cannot be deleted",
                    "links": {
                      "creditor_bank_account": "BA123"
                    }
                  }
                ]
              }
            }
        ',
        'other' => '
            {
              "error": {
                "message": "Bank account already exists",
                "documentation_url": "https://developer.gocardless.com/pro#internal_error",
                "type": "backend_failure",
                "request_id": "bd271b37-a2f5-47c8-b461-4faegvawfga",
                "code": 500,
                "errors": [
                  {
                    "reason": "backend_failure",
                    "message": "Server backend failure",
                    "links": {
                      "creditor_bank_account": "BA123"
                    }
                  }
                ]
              }
            }
        '
    );
    
    public function __construct()
    {
        parent::__construct();
    }

    private function getFixture($name)
    {
        return json_decode(self::$error_jsons[$name]);
    }

    public function testApiErrorConstructor()
    {
        $this->setExpectedException('GoCardless\Core\Error\InvalidApiUsageError');
        try {
            throw GoCardlessError::makeApiError($this->getFixture('invalid_api_usage'), 400);
        } catch (InvalidApiUsageError $e) {
            $this->assertEquals('invalid_api_usage', $e->error()->type);
            $errors = $e->errors();
            $this->assertEquals('invalid_document_structure', $errors[0]->reason);
            $this->assertEquals(400, $e->http_status());
            $this->assertEquals('https://developer.gocardless.com/pro#invalid_document_structure', $e->documentation_url());
            }
            throw $e;
    }

    public function testApiErrorConstructorNoErrorObject()
    {
        $this->setExpectedException('GoCardless\Core\Error\GoCardlessError');
        try {
            throw GoCardlessError::makeApiError($this->getFixture('other'), 400);
        } catch (GoCardlessError $e) {
            $this->assertEquals('backend_failure', $e->error()->type);
            $errors = $e->errors();
            $this->assertEquals('backend_failure', $errors[0]->reason);
            $this->assertEquals(400, $e->http_status());
            $this->assertEquals('https://developer.gocardless.com/pro#internal_error', $e->documentation_url());
            }
            throw $e;
    }

    public function testApiErrorConstructorInvalidState()
    {
       $this->setExpectedException('GoCardless\Core\Error\InvalidStateError');
        try {
            throw GoCardlessError::makeApiError($this->getFixture('invalid_state'), 410);
        } catch (InvalidStateError $e) {
            $this->assertEquals('invalid_state', $e->error()->type);
            $errors = $e->errors();
            $this->assertEquals('bank_account_cannot_delete', $errors[0]->reason);
            $this->assertEquals(410, $e->http_status());
            $this->assertEquals('https://developer.gocardless.com/pro#invalid_state_error', $e->documentation_url());
            }
            throw $e;
    }

    public function testApiErrorConstructorValidationFailed()
    {
       $this->setExpectedException('GoCardless\Core\Error\ValidationFailedError');
        try {
            throw GoCardlessError::makeApiError($this->getFixture('validation_failed'), 400);
        } catch (ValidationFailedError $e) {
            $this->assertEquals('validation_failed', $e->error()->type);
            $errors = $e->errors();
            $this->assertEquals('bank_account_exists', $errors[0]->reason);
            $this->assertEquals(400, $e->http_status());
            $this->assertEquals('https://developer.gocardless.com/pro#bank_account_exists', $e->documentation_url());
            }
            throw $e;
    }

}
