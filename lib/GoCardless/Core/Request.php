<?php

namespace GoCardless\Core;

class Request {
  private $method, $uri, $opts;

  private static $paramsMethods = array('get', 'delete');
  private static $bodyMethods = array('post', 'put');

  public function __construct($urlBase, $authenticator, $defaultHeaders, $envelopeKey) {
    $this->urlBase = $urlBase;
    $this->authenticator = $authenticator;
    $this->defaultHeaders = $defaultHeaders;
    $this->envelopeKey = $envelopeKey;
  }

  public function getMethod() {
    return $this->method;
  }
  public function getUri() {
    return $this->uri;
  }
  public function getOpts() {
    return $this->opts;
  }

  public function run($method, $path, $options = array()) {
    $method = strtolower($method);
    $postBody = null;

    if (in_array($method, self::$paramsMethods)) {
      $urlParams = http_build_query($options);
      if (substr($path, -1) == '?')
      {
        $path = $path . '&' . $urlParams;
      } else {
        $path = $path . '?' . $urlParams;
      }
    } else if (in_array($method, self::$bodyMethods)) {
      $postBody = json_encode($options);
    } else {
      throw new ClientUsageError('Unsupported HTTP Method');
    }

    $ch = curl_init($this->urlBase . $path);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "gc/phpapi v0.1");
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
    curl_setopt($ch, CURLOPT_VERBOSE, false);

    $headers = $this->defaultHeaders;

    if (isset($postBody))
    {
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
      array_push($headers, 'Content-Type: application/json');
    }

    $this->authenticator->processRequest($ch);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if ($response == false) {
      throw new HTTPError(curl_errno($ch), curl_error($ch));
    }

    $responseContentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $responseHTTPCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    $response = new Response($response, $responseHTTPCode, $responseContentType);
    // Required for JSON response types.
    $response->setUnwrapJson($this->envelopeKey);
    return $response;

  }
}

