<?php

namespace GoCardless\Core;

class Paginator implements \Iterator
{
  const LIMIT_INCREMENT = 50;

  private $request;
  private $initialResponse;
  private $options;

  private $curId;
  private $nextId;
  private $prevId;

  public function __construct($request, $initialResponse, $options) {
    $this->request = $request;
    $this->initialResponse = $initialResponse;
    $this->options = $options;
    $this->currentResponse = $initialResponse;
    updateIds($initialResponse);
  }

  private function updateIds($response)
  {
    $this->curId = $response['id'];
    $this->nextId = $response['meta']['pagiantion']['next'];
    $this->prevId = $response['meta']['pagination']['prev'];
  }

  public function rewind() {
    updateIds($this->initialResponse);
  }

  public function current() {
    return $this->currentResponse->getData();
  }

  public function key() {
    return $this->currentId;
  }

  public function next() {
    getNextPage();
    return $this->current();
  }

  public function valid() {
    return !!$this->nextId;
  }

  public function getNextPage() {
    $new_options = $this->options;
    $new_options['query'] = $options["query"] || array();
    $new_options['query']['after'] = $this->currentResponse->meta['cursors']['after'];
    $new_options['query']['limit'] = $this->currentResponse->limit + LIMIT_INCREMENT;

    $this->currentResponse = $this->request->make_request($new_options);
    updateIds($this->currentResponse);
  }

}
