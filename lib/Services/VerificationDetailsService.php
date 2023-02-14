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
use \GoCardlessPro\Resources\VerificationDetail;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the VerificationDetail
 * endpoints of the API
 *
 * @method create()
 * @method list()
 */
class VerificationDetailsService extends BaseService
{

    protected $envelope_key   = 'verification_details';
    protected $resource_class = '\GoCardlessPro\Resources\VerificationDetail';


    /**
     * Create a verification detail
     *
     * Example URL: /verification_details
     *
     * @param  string[mixed] $params An associative array for any params
     * @return VerificationDetail
     **/
    public function create($params = array())
    {
        $path = "/verification_details";
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        
        $response = $this->api_client->post($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * List verification details
     *
     * Example URL: /verification_details
     *
     * @param  string[mixed] $params An associative array for any params
     * @return ListResponse
     **/
    protected function _doList($params = array())
    {
        $path = "/verification_details";
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * List verification details
     *
     * Example URL: /verification_details
     *
     * @param  string[mixed] $params
     * @return Paginator
     **/
    public function all($params = array())
    {
        return new Paginator($this, $params);
    }

}
