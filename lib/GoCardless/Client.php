<?php

namespace GoCardless;

class Client {
  private $httpClient;
  /**
   * Constructor returning a new \GoCardless\Client class.
   */
  public function __construct($options) {
    $req_options = array();
    foreach (array('api_key', 'api_secret', 'environment') as $req_option)
    {
      if (!isset($options[$req_option])) {
        throw new \Exception('Missing required option `' . $req_option . '`.');
      }
      if (!is_string($options[$req_option])) {
        throw new \Exception('Option `'. $req_option .'` can only be a string.');
      }
      $req_options[$req_option] = $options[$req_option];
      unset($options[$req_option]);
    }
    $this->httpClient = new Core\HttpClient($req_options['api_key'], $req_options['api_secret'], $req_options['environment'], $options);
  }


    // @return [ApiKey]
    public function api_keys(){
      if (!isset($this->api_keys)) {
        $this->api_keys = new Services\ApiKey($this->httpClient);
      }
      return $this->api_keys;
    }

    // @return [Creditor]
    public function creditors(){
      if (!isset($this->creditors)) {
        $this->creditors = new Services\Creditor($this->httpClient);
      }
      return $this->creditors;
    }

    // @return [CreditorBankAccount]
    public function creditor_bank_accounts(){
      if (!isset($this->creditor_bank_accounts)) {
        $this->creditor_bank_accounts = new Services\CreditorBankAccount($this->httpClient);
      }
      return $this->creditor_bank_accounts;
    }

    // @return [Customer]
    public function customers(){
      if (!isset($this->customers)) {
        $this->customers = new Services\Customer($this->httpClient);
      }
      return $this->customers;
    }

    // @return [CustomerBankAccount]
    public function customer_bank_accounts(){
      if (!isset($this->customer_bank_accounts)) {
        $this->customer_bank_accounts = new Services\CustomerBankAccount($this->httpClient);
      }
      return $this->customer_bank_accounts;
    }

    // @return [Event]
    public function events(){
      if (!isset($this->events)) {
        $this->events = new Services\Event($this->httpClient);
      }
      return $this->events;
    }

    // @return [Helper]
    public function helpers(){
      if (!isset($this->helpers)) {
        $this->helpers = new Services\Helper($this->httpClient);
      }
      return $this->helpers;
    }

    // @return [Mandate]
    public function mandates(){
      if (!isset($this->mandates)) {
        $this->mandates = new Services\Mandate($this->httpClient);
      }
      return $this->mandates;
    }

    // @return [Payment]
    public function payments(){
      if (!isset($this->payments)) {
        $this->payments = new Services\Payment($this->httpClient);
      }
      return $this->payments;
    }

    // @return [Payout]
    public function payouts(){
      if (!isset($this->payouts)) {
        $this->payouts = new Services\Payout($this->httpClient);
      }
      return $this->payouts;
    }

    // @return [PublishableApiKey]
    public function publishable_api_keys(){
      if (!isset($this->publishable_api_keys)) {
        $this->publishable_api_keys = new Services\PublishableApiKey($this->httpClient);
      }
      return $this->publishable_api_keys;
    }

    // @return [RedirectFlow]
    public function redirect_flows(){
      if (!isset($this->redirect_flows)) {
        $this->redirect_flows = new Services\RedirectFlow($this->httpClient);
      }
      return $this->redirect_flows;
    }

    // @return [Refund]
    public function refunds(){
      if (!isset($this->refunds)) {
        $this->refunds = new Services\Refund($this->httpClient);
      }
      return $this->refunds;
    }

    // @return [Role]
    public function roles(){
      if (!isset($this->roles)) {
        $this->roles = new Services\Role($this->httpClient);
      }
      return $this->roles;
    }

    // @return [Subscription]
    public function subscriptions(){
      if (!isset($this->subscriptions)) {
        $this->subscriptions = new Services\Subscription($this->httpClient);
      }
      return $this->subscriptions;
    }

    // @return [User]
    public function users(){
      if (!isset($this->users)) {
        $this->users = new Services\User($this->httpClient);
      }
      return $this->users;
    }


  public function httpClient() {
    return $this->httpClient;
  }

}
