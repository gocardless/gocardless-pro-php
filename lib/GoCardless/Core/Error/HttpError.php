<?php

namespace GoCardless\Core\Error;

class HttpError extends \Exception
{
    private $errorNumber;
    private $errorDesc;

    public function __construct($curlErrorNo, $errorDesc)
    {
        $this->errorNumber = $curlErrorNo;
        $this->errorDesc = $errorDesc;
        parent::__construct($errorDesc . ' (' . $curlErrorNo . ')');
    }
    public function getErrorNumber()
    {
        return $this->errorNumber;
    }
    public function getErrorDesc()
    {
        return $this->errorDesc;
    }
}
