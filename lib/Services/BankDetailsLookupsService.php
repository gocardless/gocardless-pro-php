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
use \GoCardlessPro\Resources\BankDetailsLookup;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the BankDetailsLookup
 * endpoints of the API
 */
class BankDetailsLookupsService extends BaseService
{

    protected $envelope_key   = 'bank_details_lookups';
    protected $resource_class = '\GoCardlessPro\Resources\BankDetailsLookup';


    /**
     * Perform a bank details lookup
     *
     * Example URL: /bank_details_lookups
     *
     * @param  array<string, mixed> $params An associative array for any params
     * @return BankDetailsLookup
     **/
    public function create($params = array())
    {
        $path = "/bank_details_lookups";
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        
        $response = $this->api_client->post($path, $params);
        

        return $this->getResourceForResponse($response);
    }

}
