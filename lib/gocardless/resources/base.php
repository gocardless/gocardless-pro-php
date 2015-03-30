<?php

namespace <no value>;

abstract class Base
{
  private $client;
  
  public function __construct($client) 
  {
    $this->client = $client;
  }
  
  public function makeRequest($method, $uri, $opts) {
    $req = $this->client->makeRequest($this->envelopeKey());
    return $req->run($method, $uri, $opts);
  }

  abstract function envelopeKey();

  private function subUrl($url, $subs) {
  	foreach ($subs as $sub_key => $sub_val)
  	{
  		$url = str_replace(':' . $sub_key, $sub_val, $url);
  	}
  	return $url;
  }
}
