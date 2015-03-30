<?php

namespace <no value>;

use Exception;

class ApiError extends Exception
{
  private $_error;
  public function __construct($error)
  {
    $this->_error = $error;
    if ($error["documentation_url"])
    {
      super($error['message'] . ', see ' . $error['documentation_url']);
    } else {
      super($error['message']);
    }
    parent::__construct($message);   
  }
}

class ClientUsageError extends Exception {
  
}

class SchemaError extends Exception
{
  
}

class HTTPError extends Exception
{
  private $errno;
  public function __construct($errno, $errordesc)
  {
    $this->errno = $errno;
    parent::__construct($errordesc);
  }
  public function errno() {
    return $this->errno;
  }

}