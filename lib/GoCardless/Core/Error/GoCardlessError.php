<?php

namespace GoCardless\Core\Error;

class GoCardlessError extends \Exception
{
    private $error;
    private $httpStatus;
    public function __construct($error, $httpStatus)
    {
        $this->error = $error;
        $this->httpStatus = $httpStatus;
    
        if (is_object($error)) {
            $message = $error->error->message;
            if ($error->error->documentation_url) {
                $message .= (', see ' . $error->error->documentation_url);
            }
        } else {
            $message = (string)$error;
        }
        parent::__construct($message);
    }

    public static function makeApiError($error, $status)
    {
        if ($error->error->type) {
            switch ($error->error->type) {
                case 'invalid_api_usage':
                    return new InvalidApiUsageError($error, $status);

                case 'invalid_state':
                    return new InvalidStateError($error, $status);

                case 'validation_failed':
                    return new ValidationFailedError($error, $status);
            }
        }
        return new GoCardlessError($error, $status);
    }

    public function error()
    {
        return $this->error;
    }

    public function errors()
    {
        return $this->error->error->errors;
    }

    public function documentationUrl()
    {
      if (isset($this->error->documentation_url)) {
        return $this->error->documentation_url;
      }
    }

    public function httpStatus()
    {
        return $this->httpStatus;
    }
}
