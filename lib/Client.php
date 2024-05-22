<?php

namespace GoCardlessPro;

/**
 * Main GoCardlessPro Client for making API calls
 */
class Client
{

    /**
     * @var Core\ApiClient Internal reference to Api Client
     */
    private $api_client;
    private $services = [];

    /**
     * @param array $config
     *     An array of config parameters
     *
     * @type string $environment
     * @type string $access_token
     * @type float $timeout
     * @type string $http_client
     */
    public function __construct($config)
    {
        $this->validate_config($config);

        $access_token = $config['access_token'];

        if (isset($config['base_url'])) {
            $endpoint_url = $config['base_url'];
        } else if (isset($config['environment'])) {
            $endpoint_url = $this->getUrlForEnvironment($config['environment']);
        } else {
            throw new \InvalidArgumentException("Please specify an environment");
        }

        if (isset($config['http_client'])) {
            $http_client = $config['http_client'];
        } else {
            $stack = \GuzzleHttp\HandlerStack::create();
            $stack->push(RetryMiddlewareFactory::buildMiddleware());

            $timeout = 0;
            if(isset($config['timeout'])) {
                $timeout = $config['timeout'];
            }

            $http_client = new \GuzzleHttp\Client(
                [
                'base_uri' => $endpoint_url,
                'timeout' => $timeout,
                'headers' => array(
                'GoCardless-Version' => '2015-07-06',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . $access_token,
                'GoCardless-Client-Library' => 'gocardless-pro-php',
                'GoCardless-Client-Version' => '5.7.0',
                'User-Agent' => $this->getUserAgent()
                ),
                'http_errors' => false,
                'verify' => true,
                'handler' => $stack
                ]
            );
        }

        $this->api_client = new \GoCardlessPro\Core\ApiClient($http_client, $config);

        // Instantiate the services for each property
        
        $this->services['bank_authorisations'] = new Services\BankAuthorisationsService($this->api_client);
        
        $this->services['bank_details_lookups'] = new Services\BankDetailsLookupsService($this->api_client);
        
        $this->services['billing_requests'] = new Services\BillingRequestsService($this->api_client);
        
        $this->services['billing_request_flows'] = new Services\BillingRequestFlowsService($this->api_client);
        
        $this->services['billing_request_templates'] = new Services\BillingRequestTemplatesService($this->api_client);
        
        $this->services['blocks'] = new Services\BlocksService($this->api_client);
        
        $this->services['creditors'] = new Services\CreditorsService($this->api_client);
        
        $this->services['creditor_bank_accounts'] = new Services\CreditorBankAccountsService($this->api_client);
        
        $this->services['currency_exchange_rates'] = new Services\CurrencyExchangeRatesService($this->api_client);
        
        $this->services['customers'] = new Services\CustomersService($this->api_client);
        
        $this->services['customer_bank_accounts'] = new Services\CustomerBankAccountsService($this->api_client);
        
        $this->services['customer_notifications'] = new Services\CustomerNotificationsService($this->api_client);
        
        $this->services['events'] = new Services\EventsService($this->api_client);
        
        $this->services['instalment_schedules'] = new Services\InstalmentSchedulesService($this->api_client);
        
        $this->services['institutions'] = new Services\InstitutionsService($this->api_client);
        
        $this->services['logos'] = new Services\LogosService($this->api_client);
        
        $this->services['mandates'] = new Services\MandatesService($this->api_client);
        
        $this->services['mandate_imports'] = new Services\MandateImportsService($this->api_client);
        
        $this->services['mandate_import_entries'] = new Services\MandateImportEntriesService($this->api_client);
        
        $this->services['mandate_pdfs'] = new Services\MandatePdfsService($this->api_client);
        
        $this->services['negative_balance_limits'] = new Services\NegativeBalanceLimitsService($this->api_client);
        
        $this->services['payer_authorisations'] = new Services\PayerAuthorisationsService($this->api_client);
        
        $this->services['payer_themes'] = new Services\PayerThemesService($this->api_client);
        
        $this->services['payments'] = new Services\PaymentsService($this->api_client);
        
        $this->services['payouts'] = new Services\PayoutsService($this->api_client);
        
        $this->services['payout_items'] = new Services\PayoutItemsService($this->api_client);
        
        $this->services['redirect_flows'] = new Services\RedirectFlowsService($this->api_client);
        
        $this->services['refunds'] = new Services\RefundsService($this->api_client);
        
        $this->services['scenario_simulators'] = new Services\ScenarioSimulatorsService($this->api_client);
        
        $this->services['scheme_identifiers'] = new Services\SchemeIdentifiersService($this->api_client);
        
        $this->services['subscriptions'] = new Services\SubscriptionsService($this->api_client);
        
        $this->services['tax_rates'] = new Services\TaxRatesService($this->api_client);
        
        $this->services['transferred_mandates'] = new Services\TransferredMandatesService($this->api_client);
        
        $this->services['verification_details'] = new Services\VerificationDetailsService($this->api_client);
        
        $this->services['webhooks'] = new Services\WebhooksService($this->api_client);
        
    }

    
    /**
     * Service for interacting with bank authorisations
     *
     * @return Services\BankAuthorisationsService
     */
    public function bankAuthorisations()
    {
        if (!isset($this->services['bank_authorisations'])) {
            throw new \Exception('Key bank_authorisations does not exist in services array');
        }
        return $this->services['bank_authorisations'];
    }
    
    /**
     * Service for interacting with bank details lookups
     *
     * @return Services\BankDetailsLookupsService
     */
    public function bankDetailsLookups()
    {
        if (!isset($this->services['bank_details_lookups'])) {
            throw new \Exception('Key bank_details_lookups does not exist in services array');
        }
        return $this->services['bank_details_lookups'];
    }
    
    /**
     * Service for interacting with billing requests
     *
     * @return Services\BillingRequestsService
     */
    public function billingRequests()
    {
        if (!isset($this->services['billing_requests'])) {
            throw new \Exception('Key billing_requests does not exist in services array');
        }
        return $this->services['billing_requests'];
    }
    
    /**
     * Service for interacting with billing request flows
     *
     * @return Services\BillingRequestFlowsService
     */
    public function billingRequestFlows()
    {
        if (!isset($this->services['billing_request_flows'])) {
            throw new \Exception('Key billing_request_flows does not exist in services array');
        }
        return $this->services['billing_request_flows'];
    }
    
    /**
     * Service for interacting with billing request templates
     *
     * @return Services\BillingRequestTemplatesService
     */
    public function billingRequestTemplates()
    {
        if (!isset($this->services['billing_request_templates'])) {
            throw new \Exception('Key billing_request_templates does not exist in services array');
        }
        return $this->services['billing_request_templates'];
    }
    
    /**
     * Service for interacting with blocks
     *
     * @return Services\BlocksService
     */
    public function blocks()
    {
        if (!isset($this->services['blocks'])) {
            throw new \Exception('Key blocks does not exist in services array');
        }
        return $this->services['blocks'];
    }
    
    /**
     * Service for interacting with creditors
     *
     * @return Services\CreditorsService
     */
    public function creditors()
    {
        if (!isset($this->services['creditors'])) {
            throw new \Exception('Key creditors does not exist in services array');
        }
        return $this->services['creditors'];
    }
    
    /**
     * Service for interacting with creditor bank accounts
     *
     * @return Services\CreditorBankAccountsService
     */
    public function creditorBankAccounts()
    {
        if (!isset($this->services['creditor_bank_accounts'])) {
            throw new \Exception('Key creditor_bank_accounts does not exist in services array');
        }
        return $this->services['creditor_bank_accounts'];
    }
    
    /**
     * Service for interacting with currency exchange rates
     *
     * @return Services\CurrencyExchangeRatesService
     */
    public function currencyExchangeRates()
    {
        if (!isset($this->services['currency_exchange_rates'])) {
            throw new \Exception('Key currency_exchange_rates does not exist in services array');
        }
        return $this->services['currency_exchange_rates'];
    }
    
    /**
     * Service for interacting with customers
     *
     * @return Services\CustomersService
     */
    public function customers()
    {
        if (!isset($this->services['customers'])) {
            throw new \Exception('Key customers does not exist in services array');
        }
        return $this->services['customers'];
    }
    
    /**
     * Service for interacting with customer bank accounts
     *
     * @return Services\CustomerBankAccountsService
     */
    public function customerBankAccounts()
    {
        if (!isset($this->services['customer_bank_accounts'])) {
            throw new \Exception('Key customer_bank_accounts does not exist in services array');
        }
        return $this->services['customer_bank_accounts'];
    }
    
    /**
     * Service for interacting with customer notifications
     *
     * @return Services\CustomerNotificationsService
     */
    public function customerNotifications()
    {
        if (!isset($this->services['customer_notifications'])) {
            throw new \Exception('Key customer_notifications does not exist in services array');
        }
        return $this->services['customer_notifications'];
    }
    
    /**
     * Service for interacting with events
     *
     * @return Services\EventsService
     */
    public function events()
    {
        if (!isset($this->services['events'])) {
            throw new \Exception('Key events does not exist in services array');
        }
        return $this->services['events'];
    }
    
    /**
     * Service for interacting with instalment schedule
     *
     * @return Services\InstalmentSchedulesService
     */
    public function instalmentSchedules()
    {
        if (!isset($this->services['instalment_schedules'])) {
            throw new \Exception('Key instalment_schedules does not exist in services array');
        }
        return $this->services['instalment_schedules'];
    }
    
    /**
     * Service for interacting with institutions
     *
     * @return Services\InstitutionsService
     */
    public function institutions()
    {
        if (!isset($this->services['institutions'])) {
            throw new \Exception('Key institutions does not exist in services array');
        }
        return $this->services['institutions'];
    }
    
    /**
     * Service for interacting with logos
     *
     * @return Services\LogosService
     */
    public function logos()
    {
        if (!isset($this->services['logos'])) {
            throw new \Exception('Key logos does not exist in services array');
        }
        return $this->services['logos'];
    }
    
    /**
     * Service for interacting with mandates
     *
     * @return Services\MandatesService
     */
    public function mandates()
    {
        if (!isset($this->services['mandates'])) {
            throw new \Exception('Key mandates does not exist in services array');
        }
        return $this->services['mandates'];
    }
    
    /**
     * Service for interacting with mandate imports
     *
     * @return Services\MandateImportsService
     */
    public function mandateImports()
    {
        if (!isset($this->services['mandate_imports'])) {
            throw new \Exception('Key mandate_imports does not exist in services array');
        }
        return $this->services['mandate_imports'];
    }
    
    /**
     * Service for interacting with mandate import entries
     *
     * @return Services\MandateImportEntriesService
     */
    public function mandateImportEntries()
    {
        if (!isset($this->services['mandate_import_entries'])) {
            throw new \Exception('Key mandate_import_entries does not exist in services array');
        }
        return $this->services['mandate_import_entries'];
    }
    
    /**
     * Service for interacting with mandate pdfs
     *
     * @return Services\MandatePdfsService
     */
    public function mandatePdfs()
    {
        if (!isset($this->services['mandate_pdfs'])) {
            throw new \Exception('Key mandate_pdfs does not exist in services array');
        }
        return $this->services['mandate_pdfs'];
    }
    
    /**
     * Service for interacting with negative balance limit
     *
     * @return Services\NegativeBalanceLimitsService
     */
    public function negativeBalanceLimits()
    {
        if (!isset($this->services['negative_balance_limits'])) {
            throw new \Exception('Key negative_balance_limits does not exist in services array');
        }
        return $this->services['negative_balance_limits'];
    }
    
    /**
     * Service for interacting with payer authorisations
     *
     * @return Services\PayerAuthorisationsService
     */
    public function payerAuthorisations()
    {
        if (!isset($this->services['payer_authorisations'])) {
            throw new \Exception('Key payer_authorisations does not exist in services array');
        }
        return $this->services['payer_authorisations'];
    }
    
    /**
     * Service for interacting with payer theme
     *
     * @return Services\PayerThemesService
     */
    public function payerThemes()
    {
        if (!isset($this->services['payer_themes'])) {
            throw new \Exception('Key payer_themes does not exist in services array');
        }
        return $this->services['payer_themes'];
    }
    
    /**
     * Service for interacting with payments
     *
     * @return Services\PaymentsService
     */
    public function payments()
    {
        if (!isset($this->services['payments'])) {
            throw new \Exception('Key payments does not exist in services array');
        }
        return $this->services['payments'];
    }
    
    /**
     * Service for interacting with payouts
     *
     * @return Services\PayoutsService
     */
    public function payouts()
    {
        if (!isset($this->services['payouts'])) {
            throw new \Exception('Key payouts does not exist in services array');
        }
        return $this->services['payouts'];
    }
    
    /**
     * Service for interacting with payout items
     *
     * @return Services\PayoutItemsService
     */
    public function payoutItems()
    {
        if (!isset($this->services['payout_items'])) {
            throw new \Exception('Key payout_items does not exist in services array');
        }
        return $this->services['payout_items'];
    }
    
    /**
     * Service for interacting with redirect flows
     *
     * @return Services\RedirectFlowsService
     */
    public function redirectFlows()
    {
        if (!isset($this->services['redirect_flows'])) {
            throw new \Exception('Key redirect_flows does not exist in services array');
        }
        return $this->services['redirect_flows'];
    }
    
    /**
     * Service for interacting with refunds
     *
     * @return Services\RefundsService
     */
    public function refunds()
    {
        if (!isset($this->services['refunds'])) {
            throw new \Exception('Key refunds does not exist in services array');
        }
        return $this->services['refunds'];
    }
    
    /**
     * Service for interacting with scenario simulators
     *
     * @return Services\ScenarioSimulatorsService
     */
    public function scenarioSimulators()
    {
        if (!isset($this->services['scenario_simulators'])) {
            throw new \Exception('Key scenario_simulators does not exist in services array');
        }
        return $this->services['scenario_simulators'];
    }
    
    /**
     * Service for interacting with scheme identifiers
     *
     * @return Services\SchemeIdentifiersService
     */
    public function schemeIdentifiers()
    {
        if (!isset($this->services['scheme_identifiers'])) {
            throw new \Exception('Key scheme_identifiers does not exist in services array');
        }
        return $this->services['scheme_identifiers'];
    }
    
    /**
     * Service for interacting with subscriptions
     *
     * @return Services\SubscriptionsService
     */
    public function subscriptions()
    {
        if (!isset($this->services['subscriptions'])) {
            throw new \Exception('Key subscriptions does not exist in services array');
        }
        return $this->services['subscriptions'];
    }
    
    /**
     * Service for interacting with tax rates
     *
     * @return Services\TaxRatesService
     */
    public function taxRates()
    {
        if (!isset($this->services['tax_rates'])) {
            throw new \Exception('Key tax_rates does not exist in services array');
        }
        return $this->services['tax_rates'];
    }
    
    /**
     * Service for interacting with transferred mandate
     *
     * @return Services\TransferredMandatesService
     */
    public function transferredMandates()
    {
        if (!isset($this->services['transferred_mandates'])) {
            throw new \Exception('Key transferred_mandates does not exist in services array');
        }
        return $this->services['transferred_mandates'];
    }
    
    /**
     * Service for interacting with verification details
     *
     * @return Services\VerificationDetailsService
     */
    public function verificationDetails()
    {
        if (!isset($this->services['verification_details'])) {
            throw new \Exception('Key verification_details does not exist in services array');
        }
        return $this->services['verification_details'];
    }
    
    /**
     * Service for interacting with webhooks
     *
     * @return Services\WebhooksService
     */
    public function webhooks()
    {
        if (!isset($this->services['webhooks'])) {
            throw new \Exception('Key webhooks does not exist in services array');
        }
        return $this->services['webhooks'];
    }
    
    private function getUrlForEnvironment($environment)
    {
        $environment_urls = array(
            "live" => "https://api.gocardless.com/",
            "sandbox" => "https://api-sandbox.gocardless.com/"
        );

        if(!array_key_exists($environment, $environment_urls)) {
            throw new \InvalidArgumentException("$environment is not a valid environment, please use one of " . implode(", ", array_keys($environment_urls)));
        }

        return $environment_urls[$environment];
    }

    /**
     * Ensures a config is valid and sets defaults where required
     *
     * @param array[string]mixed $config the client configuration options
     */
    private function validate_config(&$config)
    {
        $required_option_keys = array('access_token', 'environment');

        foreach ($required_option_keys as $required_option_key) {
            if (!isset($config[$required_option_key])) {
                throw new \Exception('Missing required option `' . $required_option_key . '`.');
            }

            if (!is_string($config[$required_option_key])) {
                throw new \Exception('Option `'. $required_option_key .'` can only be a string.');
            }
        }

        if (!isset($config['error_on_idempotency_conflict'])) {
            $config['error_on_idempotency_conflict'] = false;
        } elseif (!is_bool($config['error_on_idempotency_conflict'])) {
            throw new \Exception('Option `error_on_idempotency_conflict` can only be a bool.');
        }
    }

    /**
     * Gets the client's user agent for API calls
     *
     * @return string
     */
    private function getUserAgent()
    {
        $curlinfo = curl_version();
        $uagent = array();
        $uagent[] = 'gocardless-pro-php/5.7.0';
        $uagent[] = 'schema-version/2015-07-06';
        if (defined('\GuzzleHttp\Client::MAJOR_VERSION')) {
            $uagent[] = 'GuzzleHttp/' . \GuzzleHttp\Client::MAJOR_VERSION;
        } else {
            // Backward compatibility for Guzzle <7.0
            $uagent[] = 'GuzzleHttp/' . \GuzzleHttp\Client::VERSION;
        }
        $uagent[] = 'php/' . phpversion();
        if (extension_loaded('curl') && function_exists('curl_version')) {
            $uagent[] = 'curl/' . \curl_version()['version'];
            $uagent[] = 'curl/' . \curl_version()['host'];
        }
        return implode(' ', $uagent);
    }
}
