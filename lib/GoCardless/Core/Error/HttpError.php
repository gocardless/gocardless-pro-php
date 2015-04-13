<?php

namespace GoCardless\Core\Error;

/**
  * Curl client library internal HTTP error Exception class.
  */
class HttpError extends \Exception
{
    /** @var int The curl error number */
    private $number;

    /** @var string The overall text error explaination */
    private $description;

    /**
      * Make a new curl error object.
      *
      * @param int $curl_error_number
      * @param string $description
      */
    public function __construct($curl_error_number, $description)
    {
        $this->number = $curl_error_number;
        $this->description = $description;
        parent::__construct($description . ' (' . $curl_error_number . ')');
    }

    /**
      * The curl error number.
      *
      * @see HttpError::$number
      * @return int
      */
    public function number()
    {
        return $this->curl_error_number;
    }
    /**
      * The curl error description.
      *
      * @see HttpError::$description
      * @return string
      */
    public function description()
    {
        return $this->description;
    }
}
