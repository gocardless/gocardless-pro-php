<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Services;

use \GoCardlessPro\Core\Paginator;
use \GoCardlessPro\Core\Util;
use \GoCardlessPro\Core\ListResponse;
use \GoCardlessPro\Resources\BillingRequestTemplate;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the BillingRequestTemplate
 * endpoints of the API
 *
 * @method ListResponse list(array $params)
 */
class BillingRequestTemplatesService extends BaseService
{

    protected $envelope_key   = 'billing_request_templates';
    protected $resource_class = '\GoCardlessPro\Resources\BillingRequestTemplate';


    /**
     * List Billing Request Templates
     *
     * Example URL: /billing_request_templates
     *
     * @param  array<string, mixed> $params An associative array for any params
     * @return ListResponse
     **/
    protected function _doList($params = array())
    {
        $path = "/billing_request_templates";
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Get a single Billing Request Template
     *
     * Example URL: /billing_request_templates/:identity
     *
     * @param  string               $identity Unique identifier, beginning with "BRT".
     * @param  array<string, mixed> $params   An associative array for any params
     * @return BillingRequestTemplate
     **/
    public function get($identity, $params = array())
    {
        $path = Util::subUrl(
            '/billing_request_templates/:identity',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Create a Billing Request Template
     *
     * Example URL: /billing_request_templates
     *
     * @param  array<string, mixed> $params An associative array for any params
     * @return BillingRequestTemplate
     **/
    public function create($params = array())
    {
        $path = "/billing_request_templates";
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        
        try {
            $response = $this->api_client->post($path, $params);
        } catch(InvalidStateException $e) {
            if ($e->isIdempotentCreationConflict()) {
                if ($this->api_client->error_on_idempotency_conflict) {
                    throw $e;
                }
                return $this->get($e->getConflictingResourceId());
            }

            throw $e;
        }
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Update a Billing Request Template
     *
     * Example URL: /billing_request_templates/:identity
     *
     * @param  string               $identity Unique identifier, beginning with "BRQ".
     * @param  array<string, mixed> $params   An associative array for any params
     * @return BillingRequestTemplate
     **/
    public function update($identity, $params = array())
    {
        $path = Util::subUrl(
            '/billing_request_templates/:identity',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        
        $response = $this->api_client->put($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * List Billing Request Templates
     *
     * Example URL: /billing_request_templates
     *
     * @param  string[mixed] $params
     * @return Paginator
     **/
    public function all($params = array())
    {
        return new Paginator($this, $params);
    }

}
