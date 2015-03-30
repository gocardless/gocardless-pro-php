<?php

namespace GoCardless;

class Response {
  private $responseBody;
  private $responseContentType;
  private $responseStatus;

  function __construct($responseBody, $responseStatus, $responseContentType) {
    $this->responseBody = $responseBody;
    $this->responseContentType = $responseContentType;
    $this->responseStatus = $responseStatus;
  }

  function setUnwrapJson($key) {
    $this->unwrapJson = $key;
  }

  function body() {
    return ($this->isJson() ? $this->jsonBody() : $this->rawBody());
  }

  function isJson() {
    return (array_include('application/json', $this->responseContentType) !== -1);
  }

  function isError() {
    return ($this->responseStatus >= 400);
  }

  function response() {
    if (!isset($this->unwrapJson))
      throw new ClientUsageError("UnwrapJSON needs to be set before getting response body");
    return $this->jsonBody()->{$this->unwrapJson};
  }

  function meta() {
    return $this->jsonBody()->meta;
  }

  public function limit() {
    return $this->jsonBody()->meta->limit;
  }

  public function getPaginator() {
    if (!$this->paginator) {
      $this->paginator = new Paginator($this);
    }
    return $this->paginator;
  }

  public function jsonBody() {
    if (!$this->jsonBodyData) {
      $this->jsonBodyData = json_decode($this->responseBody);
      $this->response = $this->jsonBodyData->{$this->unwrapJson};
      $this->meta = $this->jsonBodyData->meta;
    }
    return $this->jsonBodyData;
  }

  public function rawBody() {
    return $this->responseBody;
  }
}
