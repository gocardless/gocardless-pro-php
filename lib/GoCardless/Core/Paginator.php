<?php

namespace GoCardless\Core;

class Paginator implements \Iterator
{
    const HARD_RECORD_LIMIT = 2000;

    private $initialResponse;
    private $currentResponse;
    private $options;

    private $curPosition;
    private $maxResults;
    private $resultsCount;
    private $parent;
    private $pageStart;
    private $meta;

    public function __construct($parent, $maxResults, $response, $options)
    {
        $this->parent = $parent;
        $this->options = $options;
        $this->maxResults = min($maxResults, self::HARD_RECORD_LIMIT);
        $this->resultsCount = 0;
        $this->initialResponse = $response;
        $this->currentResponse = $response;
        $this->curPosition = 0;
        $this->pageStart = 0;
        $this->updateIds($response);
        $this->hasNextPage = true;
    }

    private function updateIds($response)
    {
        $this->resultsCount = 0;
        $this->currentResponse = $response;
        $this->pageStart = $this->curPosition;
        if (!empty($response)) {
            $this->meta = $response->meta();
        }
        $this->resultsCount += count($response);
    }

    public function rewind()
    {
        $this->curPosition = 0;
        $this->updateIds($this->initialResponse);
    }

    public function current()
    {
        return $this->currentResponse[$this->key()];
    }

    public function key()
    {
        return $this->curPosition - $this->pageStart;
    }

    public function next()
    {
        $this->curPosition++;
        $this->needsNextPage();
    }

    private function needsNextPage()
    {
        if (!isset($this->currentResponse[$this->key()])) {
            $this->nextPage();
        }
    }

    public function items()
    {
        return $this->currentResponse;
    }

    public function previousPage()
    {
        if ($this->resultsCount > $this->maxResults) {
            $this->currentResponse = array();
            return false;
        }
        $options = $this->options;
        $options['before'] = $this->meta->cursors->before;
        if (empty($options['before'])) {
            $this->currentResponse = array();
            return false;
        }
        $this->currentResponse = $this->parent->list($options);
        if (count($this->currentResponse) > 0) {
            $this->updateIds($this->currentResponse);
        }
        $this->updateIds($this->currentResponse);
        return true;
    }

    public function nextPage()
    {
        if ($this->resultsCount > $this->maxResults) {
            $this->currentResponse = array();
            return false;
        }
        $options = $this->options;
        $options['after'] = $this->meta->cursors->after;
        if (empty($options['after'])) {
            $this->currentResponse = array();
            return false;
        }
        $this->currentResponse = $this->parent->list($options);
        if (count($this->currentResponse) > 0) {
            $this->updateIds($this->currentResponse);
        }
        return true;
    }

    public function valid()
    {
        if ($this->resultsCount > $this->maxResults) {
            return false;
        }
        return !empty($response) || isset($this->currentResponse[$this->key()]);
    }
}
