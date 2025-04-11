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
use \GoCardlessPro\Resources\OutboundPayment;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the OutboundPayment
 * endpoints of the API
 *
 * @method ListResponse list(array $params)
 */
class OutboundPaymentsService extends BaseService
{

    protected $envelope_key   = 'outbound_payments';
    protected $resource_class = '\GoCardlessPro\Resources\OutboundPayment';


    /**
     * Create an outbound payment
     *
     * Example URL: /outbound_payments
     *
     * @param  array<string, mixed> $params An associative array for any params
     * @return OutboundPayment
     **/
    public function create($params = array())
    {
        $path = "/outbound_payments";
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
     * Create a withdrawal outbound payment
     *
     * Example URL: /outbound_payments/withdrawal
     *
     * @param  array<string, mixed> $params An associative array for any params
     * @return OutboundPayment
     **/
    public function withdraw($params = array())
    {
        $path = "/outbound_payments/withdrawal";
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array("data" => (object)$params['params']));
        
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
     * Cancel an outbound payment
     *
     * Example URL: /outbound_payments/:id/actions/cancel
     *
     * @param  string               $id     Unique identifier of the outbound payment.
     * @param  array<string, mixed> $params An associative array for any params
     * @return OutboundPayment
     **/
    public function cancel($id, $params = array())
    {
        $path = Util::subUrl(
            '/outbound_payments/:id/actions/cancel',
            array(
                
                'id' => $id
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array("data" => (object)$params['params']));
        
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
     * Approve an outbound payment
     *
     * Example URL: /outbound_payments/:id/actions/approve
     *
     * @param  string               $id     Unique identifier of the outbound payment.
     * @param  array<string, mixed> $params An associative array for any params
     * @return OutboundPayment
     **/
    public function approve($id, $params = array())
    {
        $path = Util::subUrl(
            '/outbound_payments/:id/actions/approve',
            array(
                
                'id' => $id
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array("data" => (object)$params['params']));
        
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
     * Get an outbound payment
     *
     * Example URL: /outbound_payments/:id
     *
     * @param  string               $id     Unique identifier of the outbound payment.
     * @param  array<string, mixed> $params An associative array for any params
     * @return OutboundPayment
     **/
    public function get($id, $params = array())
    {
        $path = Util::subUrl(
            '/outbound_payments/:id',
            array(
                
                'id' => $id
            )
        );
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * List outbound payments
     *
     * Example URL: /outbound_payments
     *
     * @param  array<string, mixed> $params An associative array for any params
     * @return ListResponse
     **/
    protected function _doList($params = array())
    {
        $path = "/outbound_payments";
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Update an outbound payment
     *
     * Example URL: /outbound_payments/:id
     *
     * @param  string               $id     Unique identifier of the outbound payment.
     * @param  array<string, mixed> $params An associative array for any params
     * @return OutboundPayment
     **/
    public function update($id, $params = array())
    {
        $path = Util::subUrl(
            '/outbound_payments/:id',
            array(
                
                'id' => $id
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
     * List outbound payments
     *
     * Example URL: /outbound_payments
     *
     * @param  string[mixed] $params
     * @return Paginator
     **/
    public function all($params = array())
    {
        return new Paginator($this, $params);
    }

}
