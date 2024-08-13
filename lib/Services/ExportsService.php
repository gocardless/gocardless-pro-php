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
use \GoCardlessPro\Resources\Export;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the Export
 * endpoints of the API
 *
 * @method get()
 * @method list()
 */
class ExportsService extends BaseService
{

    protected $envelope_key   = 'exports';
    protected $resource_class = '\GoCardlessPro\Resources\Export';


    /**
     * Get a single export
     *
     * Example URL: /exports/:identity
     *
     * @param  string        $identity Unique identifier, beginning with "EX".
     * @param  string[mixed] $params   An associative array for any params
     * @return Export
     **/
    public function get($identity, $params = array())
    {
        $path = Util::subUrl(
            '/exports/:identity',
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
     * List exports
     *
     * Example URL: /exports
     *
     * @param  string[mixed] $params An associative array for any params
     * @return ListResponse
     **/
    protected function _doList($params = array())
    {
        $path = "/exports";
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        
        $response = $this->api_client->get($path, $params);
        

        return $this->getResourceForResponse($response);
    }

    /**
     * List exports
     *
     * Example URL: /exports
     *
     * @param  string[mixed] $params
     * @return Paginator
     **/
    public function all($params = array())
    {
        return new Paginator($this, $params);
    }

}