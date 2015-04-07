<?php

namespace GoCardless\Core;

class Response {
  private $responseBody;
  private $responseContentType;
  private $responseStatus;

  function __construct($responseBody, $responseStatus, $responseContentType)
  {
    $this->responseBody = $responseBody;
    $this->responseContentType = $responseContentType;
    $this->responseStatus = $responseStatus;
    if ($this->isError())
    {
      $this->handleError();
    }
  }

  function handleError() {
    $error = $this->isJson() ? $this->jsonBody() : $this->rawBody();
    throw Error\GoCardlessError::makeApiError($error, $this->status());
  }

  function setUnwrapJson($key) {
    $this->unwrapJson = $key;
  }

  function status() {
    return $this->responseStatus;
  }

  function body() {
    return ($this->isJson() ? $this->jsonBody() : $this->rawBody());
  }

  function isJson() {
    return (strpos($this->responseContentType, 'application/json') === 0);
  }

  function isError() {
    return ($this->responseStatus >= 400);
  }

  function response() {
    if (!isset($this->unwrapJson))
    {
      throw new \Exception("UnwrapJSON needs to be set before getting response body");
    }
    return $this->jsonBody()->{$this->unwrapJson};
  }

  function meta() {
    return $this->jsonBody()->meta;
  }

  public function limit() {
    return $this->jsonBody()->meta->limit;
  }

  public function jsonBody() {
    if (!isset($this->jsonBodyData))
    {
      $this->jsonBodyData = json_decode($this->responseBody);
    }
    return $this->jsonBodyData;
  }

  public function rawBody() {
    return $this->responseBody;
  }
}
