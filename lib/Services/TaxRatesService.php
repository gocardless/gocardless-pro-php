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
use \GoCardlessPro\Resources\TaxRate;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the TaxRate
 * endpoints of the API
 *
 * @method ListResponse list(array $params)
 */
class TaxRatesService extends BaseService
{

    protected $envelope_key   = 'tax_rates';
    protected $resource_class = '\GoCardlessPro\Resources\TaxRate';


    /**
     * List tax rates
     *
     * Example URL: /tax_rates
     *
     * @param  array<string, mixed> $params An associative array for any params
     * @return ListResponse
     **/
    protected function _doList($params = array())
    {
        $path = "/tax_rates";
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * Get a single tax rate
     *
     * Example URL: /tax_rates/:identity
     *
     * @param  string               $identity The unique identifier created by the jurisdiction, tax type
     *                                        and version
     * @param  array<string, mixed> $params   An associative array for any params
     * @return TaxRate
     **/
    public function get($identity, $params = array())
    {
        $path = Util::subUrl(
            '/tax_rates/:identity',
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
     * List tax rates
     *
     * Example URL: /tax_rates
     *
     * @param  string[mixed] $params
     * @return Paginator
     **/
    public function all($params = array())
    {
        return new Paginator($this, $params);
    }

}
