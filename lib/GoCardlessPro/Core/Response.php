<?php

namespace GoCardlessPro\Core;

/**
  * HTTP Response Object
  * Allows determining JSON/raw content type and unwrapping JSON responses
  * Additionally, gives you the ability to get more detailed http response information.
  * @author Iain Nash
  * @package GoCardlessPro
  * @subpackage Core
  */
class Response
{
    /** @var string Response Body */
    private $body;
    /** @var string Response Content Type */
    private $content_type;
    /** @var int Response HTTP Status */
    private $status;

  /**
    * @param string $body
    * @param integer $status
    * @param string $content_type
    * @param array[string]string $headers Will be downcased when copied
    */
    public function __construct($body, $status, $content_type, $headers = array())
    {
        $this->body = $body;
        $this->content_type = $content_type;
        $this->status = $status;

        // Downcase header keys for consistency.
        foreach ($headers as $key => $value) {
            $this->headers[strtolower($key)] = $value;
        }

        if ($this->is_error()) {
            $this->handle_error();
        }
    }

  /**
    * If there is an error in the http headers, decode the json body into an
    * error object and throw it.
    * @throws Error\GoCardlessError
    */
    public function handle_error()
    {
        $error = $this->is_json() ? $this->json_body() : $this->raw_body();
        throw Error\GoCardlessError::makeApiError($error, $this->status());
    }

  /**
    * Sets the unwrap json value. Required for json responses.
    * @param string $key the unwrap key.
    */
    public function set_unwrap_json($key)
    {
        $this->unwrap_json = $key;
    }

  /**
    * Gets the response content-type
    * @return string
    */
    public function content_type()
    {
        return $this->content_type;
    }

  /**
    * Gets all the HTTP headers with lowercased keys
    * @return array[string]string
    */
    public function headers()
    {
        return $this->headers;
    }

  /**
    * Get a single HTTP header (case-insensitive)
    * @return string
    */
    public function header($name)
    {
        $key = strtolower($name);
        if (isset($this->headers[$key])) {
            return $this->headers[$key];
        }
        return null;
    }

  /**
    * Get the HTTP status of the response
    * @return int
    */
    public function status()
    {
        return $this->status;
    }

  /**
    * Returns either the full decoded json body or the raw body of the reponse.
    */
    public function body()
    {
        return ($this->is_json() ? $this->json_body() : $this->raw_body());
    }

  /**
    * Checks the content_type to see if the response is json.
    * @return bool
    */
    public function is_json()
    {
        return (strpos($this->content_type, 'application/json') === 0);
    }

  /**
    * Checks if this response is an error response
    * @return bool
    */
    public function is_error()
    {
        return ($this->status >= 400);
    }

  /**
    * Get the unwrapped json body response, only works for json responses.
    */
    public function response()
    {
        if (!isset($this->unwrap_json)) {
            throw new \Exception("UnwrapJSON needs to be set before getting response body");
        }
        return $this->json_body()->{$this->unwrap_json};
    }

  /**
    * Gets the meta information in wrapped json responses
    * @return stdClass
    */
    public function meta()
    {
        return new \GoCardlessPro\Resources\Wrapper\NestedObject('meta', $this->json_body()->meta);
    }

  /**
    * Gets the limit in json body responses.
    * @return int
    */
    public function limit()
    {
        return $this->json_body()->meta->limit;
    }

  /**
    * Returns the decoded full json body
    * @return stdClass
    */
    public function json_body()
    {
        if (!isset($this->json_body_data)) {
            $this->json_body_data = json_decode($this->body, false);
        }
        return $this->json_body_data;
    }

  /**
    * Gets the raw body string in all cases.
    * @return string
    */
    public function raw_body()
    {
        return $this->body;
    }
}
