<?php

namespace GoCardlessPro;

/**
  * Main GoCardlessPro Client class, when created it allows access to the API.
  */
class Client
{
    /** @var Core/HttpClient Internal reference to HTTP Client object */
    private $http_client;
    
    /**
     * Constructor returning a new \GoCardless\Client class.
     * @param array[string]string $options Options (required: api_secret, api_key, optional: environment).
     */
    public function __construct($options)
    {
        $req_options = array();
        if (!isset($options['environment'])) {
            $options['environment'] = Environment::PRODUCTION;
        }
        foreach (array('access_token', 'environment') as $req_option) {
            if (!isset($options[$req_option])) {
                throw new \Exception('Missing required option `' . $req_option . '`.');
            }
            if (!is_string($options[$req_option])) {
                throw new \Exception('Option `'. $req_option .'` can only be a string.');
            }
            $req_options[$req_option] = $options[$req_option];
            unset($options[$req_option]);
        }
        if (!empty($options)) {
            throw new \Exception('Unexpected options passed in: ' . implode(', ', array_keys($options)));
        }
        $this->http_client = new Core\HttpClient(
            $req_options['access_token'],
            $req_options['environment'],
            $options
        );
    }


  /**
    * Bank Details Lookups
    *
    * Look up the name and reachability of a bank.
    *
    * @return Services\BankDetailsLookup
    */
    public function bank_details_lookups()
    {
        if (!isset($this->bank_details_lookups)) {
            $this->bank_details_lookups = new Services\BankDetailsLookupsService($this->http_client);
        }
        return $this->bank_details_lookups;
    }

  /**
    * Creditors
    *
    * Each [payment](#core-endpoints-payments) taken through the API is linked
    * to a "creditor", to whom the payment is then paid out. In most cases your
    * organisation will have a single "creditor", but the API also supports
    * collecting payments on behalf of others.
    * 
    * Please get in touch
    * if you wish to use this endpoint. Currently, for Anti Money Laundering
    * reasons, any creditors you add must be directly related to your
    * organisation.
    *
    * @return Services\Creditor
    */
    public function creditors()
    {
        if (!isset($this->creditors)) {
            $this->creditors = new Services\CreditorsService($this->http_client);
        }
        return $this->creditors;
    }

  /**
    * Creditor Bank Accounts
    *
    * Creditor Bank Accounts hold the bank details of a
    * [creditor](#core-endpoints-creditor). These are the bank accounts which
    * your [payouts](#core-endpoints-payouts) will be sent to.
    * 
    * Note
    * that creditor bank accounts must be unique, and so you will encounter a
    * `bank_account_exists` error if you try to create a duplicate bank account.
    * You may wish to handle this by updating the existing record instead, the
    * ID of which will be provided as `links[creditor_bank_account]` in the
    * error response.
    *
    * @return Services\CreditorBankAccount
    */
    public function creditor_bank_accounts()
    {
        if (!isset($this->creditor_bank_accounts)) {
            $this->creditor_bank_accounts = new Services\CreditorBankAccountsService($this->http_client);
        }
        return $this->creditor_bank_accounts;
    }

  /**
    * Customers
    *
    * Customer objects hold the contact details for a customer. A customer can
    * have several [customer bank
    * accounts](#core-endpoints-customer-bank-accounts), which in turn can have
    * several Direct Debit [mandates](#core-endpoints-mandates).
    *
    * @return Services\Customer
    */
    public function customers()
    {
        if (!isset($this->customers)) {
            $this->customers = new Services\CustomersService($this->http_client);
        }
        return $this->customers;
    }

  /**
    * Customer Bank Accounts
    *
    * Customer Bank Accounts hold the bank details of a
    * [customer](#core-endpoints-customers). They always belong to a
    * [customer](#core-endpoints-customers), and may be linked to several Direct
    * Debit [mandates](#core-endpoints-mandates).
    * 
    * Note that
    * customer bank accounts must be unique, and so you will encounter a
    * `bank_account_exists` error if you try to create a duplicate bank account.
    * You may wish to handle this by updating the existing record instead, the
    * ID of which will be provided as links[customer_bank_account] in the error
    * response.
    *
    * @return Services\CustomerBankAccount
    */
    public function customer_bank_accounts()
    {
        if (!isset($this->customer_bank_accounts)) {
            $this->customer_bank_accounts = new Services\CustomerBankAccountsService($this->http_client);
        }
        return $this->customer_bank_accounts;
    }

  /**
    * Events
    *
    * Events are stored for all webhooks. An event refers to a resource which
    * has been updated, for example a payment which has been collected, or a
    * mandate which has been transferred.
    *
    * @return Services\Event
    */
    public function events()
    {
        if (!isset($this->events)) {
            $this->events = new Services\EventsService($this->http_client);
        }
        return $this->events;
    }

  /**
    * Helpers
    *
    * @return Services\Helper
    */
    public function helpers()
    {
        if (!isset($this->helpers)) {
            $this->helpers = new Services\HelpersService($this->http_client);
        }
        return $this->helpers;
    }

  /**
    * Mandates
    *
    * Mandates represent the Direct Debit mandate with a
    * [customer](#core-endpoints-customers).
    * 
    * GoCardless will notify
    * you via a [webhook](#webhooks) whenever the status of a mandate changes.
    *
    * @return Services\Mandate
    */
    public function mandates()
    {
        if (!isset($this->mandates)) {
            $this->mandates = new Services\MandatesService($this->http_client);
        }
        return $this->mandates;
    }

  /**
    * Mandate PDFs
    *
    * Mandate PDFs allow you to easily display [scheme-rules
    * compliant](#ui-compliance-requirements) Direct Debit mandates to your
    * customers.
    *
    * @return Services\MandatePdf
    */
    public function mandate_pdfs()
    {
        if (!isset($this->mandate_pdfs)) {
            $this->mandate_pdfs = new Services\MandatePdfsService($this->http_client);
        }
        return $this->mandate_pdfs;
    }

  /**
    * Payments
    *
    * Payment objects represent payments from a
    * [customer](#core-endpoints-customers) to a
    * [creditor](#core-endpoints-creditors), taken against a Direct Debit
    * [mandate](#core-endpoints-mandates).
    * 
    * GoCardless will notify
    * you via a [webhook](#webhooks) whenever the state of a payment changes.
    *
    * @return Services\Payment
    */
    public function payments()
    {
        if (!isset($this->payments)) {
            $this->payments = new Services\PaymentsService($this->http_client);
        }
        return $this->payments;
    }

  /**
    * Payouts
    *
    * Payouts represent transfers from GoCardless to a
    * [creditor](#core-endpoints-creditors). Each payout contains the funds
    * collected from one or many [payments](#core-endpoints-payments). Payouts
    * are created automatically after a payment has been successfully collected.
    *
    * @return Services\Payout
    */
    public function payouts()
    {
        if (!isset($this->payouts)) {
            $this->payouts = new Services\PayoutsService($this->http_client);
        }
        return $this->payouts;
    }

  /**
    * Redirect Flows
    *
    * Redirect flows enable you to use GoCardless Pro's [hosted payment
    * pages](https://pay-sandbox.gocardless.com/AL000000AKFPFF) to set up
    * mandates with your customers. These pages are fully compliant and have
    * been translated into Dutch, French, German, Italian, Portuguese and
    * Spanish.
    * 
    * The overall flow is:
    * 
    * 1. You
    * [create](#create-a-redirect-flow) a redirect flow for your customer, and
    * redirect them to the returned redirect url, e.g.
    * `https://pay.gocardless.com/flow/RE123`.
    * 
    * 2. Your customer
    * supplies their name, email, address, and bank account details, and submits
    * the form. This securely stores their details, and redirects them back to
    * your `success_redirect_url` with `redirect_flow_id=RE123` in the
    * querystring.
    * 
    * 3. You [complete](#complete-a-redirect-flow) the
    * redirect flow, which creates a [customer](#core-endpoints-customers),
    * [customer bank account](#core-endpoints-customer-bank-accounts), and
    * [mandate](#core-endpoints-mandates), and returns the ID of the mandate.
    * You may wish to create a [subscription](#core-endpoints-subscriptions) or
    * [payment](#core-endpoints-payments) at this point.
    * 
    * It is
    * recommended that you link the redirect flow to your user object as soon as
    * it is created, and attach the created resources to that user in the
    * complete step.
    * 
    * Redirect flows expire 30 minutes after they
    * are first created. You cannot complete an expired redirect flow.
    *
    * @return Services\RedirectFlow
    */
    public function redirect_flows()
    {
        if (!isset($this->redirect_flows)) {
            $this->redirect_flows = new Services\RedirectFlowsService($this->http_client);
        }
        return $this->redirect_flows;
    }

  /**
    * Refunds
    *
    * Refund objects represent (partial) refunds of a
    * [payment](#core-endpoints-payment) back to the
    * [customer](#core-endpoints-customers).
    * 
    * GoCardless will notify
    * you via a [webhook](#webhooks) whenever a refund is created, and will
    * update the `amount_refunded` property of the payment.
    * 
    * _Note:_
    * A payment that has been (partially) refunded can still receive a late
    * failure or chargeback from the banks.
    *
    * @return Services\Refund
    */
    public function refunds()
    {
        if (!isset($this->refunds)) {
            $this->refunds = new Services\RefundsService($this->http_client);
        }
        return $this->refunds;
    }

  /**
    * Subscriptions
    *
    * Subscriptions create [payments](#core-endpoints-payments) according to a
    * schedule.
    * 
    * #### Recurrence Rules
    * 
    * The following
    * rules apply when specifying recurrence:
    * - The first payment must be
    * charged within 1 year.
    * - When neither `month` nor `day_of_month` are
    * present, the subscription will recur from the `start_at` based on the
    * `interval_unit`.
    * - If `month` or `day_of_month` are present, the
    * recurrence rules will be applied from the `start_at`, and the following
    * validations apply:
    * 
    * | interval_unit   | month                 
    *                         | day_of_month                            |
    *
    * | :-------------- | :--------------------------------------------- |
    * :-------------------------------------- |
    * | yearly          |
    * optional (required if `day_of_month` provided) | optional (required if
    * `month` provided) |
    * | monthly         | invalid                     
    *                   | required                                |
    * |
    * weekly          | invalid                                        | invalid
    *                                 |
    * 
    * Examples:
    * 
    * |
    * interval_unit   | interval   | month   | day_of_month   | valid?          
    *                                   |
    * | :-------------- | :--------- |
    * :------ | :------------- |
    * :------------------------------------------------- |
    * | yearly       
    *   | 1          | january | -1             | valid                         
    *                     |
    * | yearly          | 1          | march   |    
    *            | invalid - missing `day_of_month`                   |
    * |
    * monthly         | 6          |         | 12             | valid           
    *                                   |
    * | monthly         | 6          |
    * august  | 12             | invalid - `month` must be blank                
    *    |
    * | weekly          | 2          |         |                |
    * valid                                              |
    * | weekly       
    *   | 2          | october | 10             | invalid - `month` and
    * `day_of_month` must be blank |
    * 
    * #### Rolling dates
    * 
   
    * * When a charge date falls on a non-business day, one of two things will
    * happen:
    * 
    * - if the recurrence rule specified `-1` as the
    * `day_of_month`, the charge date will be rolled __backwards__ to the
    * previous business day (i.e., the last working day of the month).
    * -
    * otherwise the charge date will be rolled __forwards__ to the next business
    * day.
    * 
    *
    * @return Services\Subscription
    */
    public function subscriptions()
    {
        if (!isset($this->subscriptions)) {
            $this->subscriptions = new Services\SubscriptionsService($this->http_client);
        }
        return $this->subscriptions;
    }


  /**
    * Get the client library's internal http client.
    * @return Core\HttpClient
    */
    public function http_client()
    {
        return $this->http_client;
    }
}
