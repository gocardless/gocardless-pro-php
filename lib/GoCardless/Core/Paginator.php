<?php

namespace GoCardless\Core;

/**
  * Class allowing for pagination of resources.
  * @implements \Iterator
  */
class Paginator implements \Iterator
{
    /** Hard record limit to retrieve in one cursor */
    const HARD_RECORD_LIMIT = 2000;

    /** @var \GoCardless\ListResponse First response page (used to loop multiple times) */
    private $initial_response;

    /** @var \GoCardless\ListResponse Current response page */
    private $current_response;

    /** @var array[string]mixed Fetch options called on every page load */
    private $options;

    /** @var int The current integer position offset */
    private $current_position;

    /** @var int Integer position of where the current page starts */
    private $page_start;

    /** @var int The max result number passed in on initialisation */
    private $max_results;
    
    /** @var int The current number of results fetched */
    private $results_count;

    /** @var \GoCardless\Services\Base The parent service class to fetch records from */
    private $parent;

    /** @var \GoCardless\Resources\Wrapper\NestedObject Meta information for the current page */
    private $meta;

  /**
    * Creates the paginator
    * @param Base $parent Parent service class to fetch more records
    * @param integer $max_results Max number of results to paginate
    * @param Response $response Response resource for the initial page
    * @param array[mixed]mixed Request options to send querying for additional pages. 
    */
    public function __construct($parent, $max_results, $response, $options, $headers)
    {
        $this->parent = $parent;
        $this->options = $options;
        $this->headers = $headers;
        $this->max_results = min($max_results, self::HARD_RECORD_LIMIT);
        $this->results_count = 0;
        $this->initial_response = $response;
        $this->current_response = $response;
        $this->current_position = 0;
        $this->page_start = 0;
        $this->update_ids($response);
    }

  /**
    * Reset current page to response
    * @param Response $response Response object to set to current page
    */
    private function update_ids($response)
    {
        $this->results_count = 0;
        $this->current_response = $response;
        $this->page_start = $this->current_position;
        if (!empty($response)) {
            $this->meta = $response->meta();
        }
        $this->results_count += count($response);
    }

  /**
    * Rewind to the first page for foreach iterators
    */
    public function rewind()
    {
        $this->current_position = 0;
        $this->update_ids($this->initial_response);
    }

  /**
    * Get the current element for foreach iterators
    * @return Response
    */
    public function current()
    {
        return $this->current_response[$this->key()];
    }

  /**
    * Gets the current iteration key
    * return string
    */
    public function key()
    {
        return $this->current_position - $this->page_start;
    }

  /**
    * Gets the next element in the iterator
    */
    public function next()
    {
        $this->current_position++;
        $this->needs_next_page();
    }

  /**
    * Internal function to determine if loading the next page is necessary.
    */
    private function needs_next_page()
    {
        if (!isset($this->current_response[$this->key()])) {
            $this->next_page();
        }
    }

  /**
    * Gets the current page of items.
    * @return ListResponse
    */
    public function items()
    {
        return $this->current_response;
    }

  /**
    * Fetches the previous page.
    * @return bool (true on success)
    */
    public function previous_page()
    {
        if ($this->results_count > $this->max_results) {
            $this->current_response = array();
            return false;
        }
        $options = $this->options;
        $options['before'] = $this->meta->cursors()->before();
        if (empty($options['before'])) {
            $this->current_response = array();
            return false;
        }
        return $this->get_server_response($options);
    }

  /**
    * Fetches the next page
    * @return bool (true on success)
    */
    public function next_page()
    {
        if ($this->results_count > $this->max_results) {
            $this->current_response = array();
            return false;
        }
        $options = $this->options;
        $options['after'] = $this->meta->cursors()->after();
        if (empty($options['after'])) {
            $this->current_response = array();
            return false;
        }
        return $this->get_server_response($options);
    }

  /**
    * Helper function to get server responses from the webservice.
    * 
    * @param $options array[string]string Set of options to pass to request
    * @return bool
    */
    private function get_server_response($options)
    {
        $this->current_response = $this->parent->list($options, $this->headers);
        if (count($this->current_response) > 0) {
            $this->update_ids($this->current_response);
        }
        $this->update_ids($this->current_response);
        return true;
    }

  /**
    * Returns if the current page is a valid page (called by foreach)
    * @return bool
    */
    public function valid()
    {
        if ($this->results_count > $this->max_results) {
            return false;
        }
        return !empty($response) || isset($this->current_response[$this->key()]);
    }
}
