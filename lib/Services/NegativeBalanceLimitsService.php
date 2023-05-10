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
use \GoCardlessPro\Resources\NegativeBalanceLimit;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the NegativeBalanceLimit
 * endpoints of the API
 *
 * @method list()
 * @method create()
 */
class NegativeBalanceLimitsService extends BaseService
{

    protected $envelope_key   = 'negative_balance_limits';
    protected $resource_class = '\GoCardlessPro\Resources\NegativeBalanceLimit';


    /**
     * List negative balance limits
     *
     * Example URL: /negative_balance_limits
     *
     * @param  string[mixed] $params An associative array for any params
     * @return ListResponse
     **/
    protected function _doList($params = array())
    {
        $path = "/negative_balance_limits";
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Create a negative balance limit
     *
     * Example URL: /negative_balance_limits
     *
     * @param  string[mixed] $params An associative array for any params
     * @return NegativeBalanceLimit
     **/
    public function create($params = array())
    {
        $path = "/negative_balance_limits";
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        
        $response = $this->api_client->post($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * List negative balance limits
     *
     * Example URL: /negative_balance_limits
     *
     * @param  string[mixed] $params
     * @return Paginator
     **/
    public function all($params = array())
    {
        return new Paginator($this, $params);
    }

}
