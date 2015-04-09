<?php

namespace GoCardless\Services;

/**
  * Service Base class for all service models.
  * Facilitates calling normally reserved methods, creating http requests, and building urls.
  * Also defines an abstract envelopeKey and resourceClass methods.
  * @author Iain Nash
  * @version 1.0
  * @package GoCardless
  * @subpackage Services
  */
abstract class Base
{
    private $client;

  /**
    * Constructor for all base services, passes in the internal http client.
    * @param \GoCardless\Core\HttpClient $client HttpClient object.
    */
    public function __construct($client)
    {
        $this->client = $client;
    }

  /**
    * Function to make a http request and return the appropriate response object.
    * @param string $method The HTTP request method
    * @param string $uri The relative uri to call in the api.
    * @param array[string]string The array of uri parameters (GET/DELETE requests)
    *     or json body (POST/PUT) to send.
    */
    public function makeRequest($method, $uri, $opts)
    {
        $req = $this->client->makeRequest($this->envelopeKey());
        $response = $req->run($method, $uri, $opts);
        $resourceClass = $this->resourceClass();
        if (is_array($response->response())) {
            return new \GoCardless\Core\ListResponse($resourceClass, $response);
        } else {
            return new $resourceClass($response->response(), $response);
        }
    }

  /**
    * The envelope key to unenvelope and envelope requests to the API.
    * @return string
    */
    abstract protected function envelopeKey();
  /**
    * The classname of the returned resource, used to resolve decoding JSON responses.
    * @return string
    */
    abstract protected function resourceClass();

  /**
    * Handles functions in the API that are normally PHP reserved words.
    */
    public function __call($name, $args)
    {
        $attemptName = 'do_' . $name;
        if (method_exists($this, $attemptName)) {
            return call_user_func_array(array($this, $attemptName), $args);
        }
        return false;
    }

  /**
    * SubUrl replaces colon tokens with the array->value associations
    * in the subs array to generate urls.
    * @param string $url Url to substitute
    * @param array[string]string $subs Substitutions to make
    * @return string 
    */
    protected function subUrl($url, $subs)
    {
        foreach ($subs as $sub_key => $sub_val) {
            if (!is_string($sub_val)) {
                $error_type = ' needs to be a string, not a '.gettype($sub_val).'.';
                throw new \Exception('URL value for ' . $sub_key . $error_type);
            }
            $url = str_replace(':' . $sub_key, $sub_val, $url);
        }
        return $url;
    }
}
