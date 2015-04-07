<?php

namespace GoCardless\Services;

abstract class Base
{
  private $client;

  public function __construct($client)
  {
    $this->client = $client;
  }

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

  protected abstract function envelopeKey();
  protected abstract function resourceClass();

  protected function subUrl($url, $subs)
  {
    foreach ($subs as $sub_key => $sub_val)
    {
      $url = str_replace(':' . $sub_key, $sub_val, $url);
    }
    return $url;
  }
}
