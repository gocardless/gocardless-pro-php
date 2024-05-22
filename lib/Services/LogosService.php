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
use \GoCardlessPro\Resources\Logo;
use \GoCardlessPro\Core\Exception\InvalidStateException;


/**
 * Service that provides access to the Logo
 * endpoints of the API
 *
 * @method createForCreditor()
 */
class LogosService extends BaseService
{

    protected $envelope_key   = 'logos';
    protected $resource_class = '\GoCardlessPro\Resources\Logo';


    /**
     * Create a logo associated with a creditor
     *
     * Example URL: /creditors/:identity/branding/logos
     *
     * @param  string        $identity Unique identifier, beginning with "CR".
     * @param  string[mixed] $params   An associative array for any params
     * @return Logo
     **/
    public function createForCreditor($identity, $params = array())
    {
        $path = Util::subUrl(
            '/creditors/:identity/branding/logos',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        
        $response = $this->api_client->post($path, $params);
        

        return $this->getResourceForResponse($response);
    }

}
