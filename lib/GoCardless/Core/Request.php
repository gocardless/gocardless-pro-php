<?php

namespace GoCardless\Core;

/**
  * Request class wrapping a request, envelope key, and a run method returning a http response
  */
class Request
{
    private $httpClient;
    private $envelopeKey;

  /**
    * Valid methods to send url parameters for 
    */
    private static $paramsMethods = array('get', 'delete');
  /**
    * Valid method to send a json-encoded postbody for
    */
    private static $bodyMethods   = array('post', 'put');

  /**
    * Constructor for a request class to wrap a request
    * @param HttpClient $client HTTP Client Reference
    * @param string $envelopeKey Envelope Key
    */
    public function __construct($httpClient, $envelopeKey)
    {
        $this->httpClient = $httpClient;
        $this->envelopeKey = $envelopeKey;
    }

  /**
    * 
    * @param string $method HTTP Method
    * @param string $path Relative Path for Request
    * @param array[string]string $options URL parameter or post body options
    * @param array[string]string $headers Additionall request headers
    * @return Response
    */
    public function run($method, $path, $options, $headers = array())
    {
        $method = strtolower($method);
        $postBody = null;

        if (in_array($method, self::$paramsMethods)) {
            $urlParams = http_build_query($options);
            if (substr($path, -1) === '?' || substr($path, -1) === '&') {
                $path = $path . $urlParams;
            } elseif (strstr($path, '?') !== false) {
                $path = $path . '&' . $urlParams;
            } else {
                $path = $path . '?' . $urlParams;
            }
        } elseif (in_array($method, self::$bodyMethods)) {
            $postBody = json_encode(array($this->envelopeKey => $options));
        } else {
            throw new ClientUsageError('Unsupported HTTP Method');
        }

        $responseData = $this->httpClient->runCurlRequest($method, $path, $postBody, $headers);

        // Passes in keys ['body', 'status', 'content-type', 'headers'].
        $response = new Response($responseData['body'], $responseData['status'], $responseData['content-type'], $responseData['headers']);

        // Required for JSON response types.
        $response->set_unwrap_json($this->envelopeKey);
        return $response;
    }
}
