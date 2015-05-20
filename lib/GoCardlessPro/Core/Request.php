<?php

namespace GoCardlessPro\Core;

/**
  * Request class wrapping a request, envelope key, and a run method returning a http response
  */
class Request
{
    /** @var HttpClient HTTP Client reference for requests */
    private $http_client;
    
    /** @var string JSON Envelope data key */
    private $envelope_key;

    /** @const string[] Valid methods to send url parameters for */
    private static $params_methods = array('get', 'delete');

    /** @const string[] Valid method to send a json-encoded postbody for */
    private static $body_methods   = array('post', 'put');

  /**
    * Constructor for a request class to wrap a request
    *
    * @param HttpClient $http_client HTTP Client Reference
    * @param string $envelope_key Envelope Key
    */
    public function __construct($http_client, $envelope_key)
    {
        $this->http_client = $http_client;
        $this->envelope_key = $envelope_key;
    }

  /**
    * Gets the request envelope key.
    * @param string $type request type to match
    */
    private function getReqEnvelopeKey($type)
    {
        if ($type !== 'create' && $type !== 'update') {
            return 'data';
        }
        return $this->envelope_key;
    }

  /**
    * Runs a raw HTTP request
    *
    * @param string $method HTTP Method
    * @param string $path Relative Path for Request
    * @param array[string]string $options URL parameter or post body options
    * @param array[string]string $headers Additional request headers
    *
    * @uses Request::$envelope_key
    * @uses Request::$http_client
    *
    * @return Response
    */
    public function run($type, $method, $path, $options, $headers = array())
    {
        $method = strtolower($method);
        $postBody = null;

        // Envelope key fix: data on all actions that are not create or update with a post body.
        $req_envelope_key = $this->getReqEnvelopeKey($type);

        if (in_array($method, self::$params_methods)) {
            $urlParams = http_build_query($options);
            if (substr($path, -1) === '?' || substr($path, -1) === '&') {
                $path = $path . $urlParams;
            } elseif (strstr($path, '?') !== false) {
                $path = $path . '&' . $urlParams;
            } elseif (!empty($urlParams)) {
                $path = $path . '?' . $urlParams;
            }
        } elseif (in_array($method, self::$body_methods)) {
            $postBody = json_encode(array($this->getReqEnvelopeKey($type) => $options));
        } else {
            throw new \Exception('Unsupported HTTP Method');
        }

        $response = $this->http_client->run_curl_request($method, $path, $postBody, $headers);

        // Required for JSON response types.
        $response->set_unwrap_json($this->envelope_key);

        return $response;
    }
}
