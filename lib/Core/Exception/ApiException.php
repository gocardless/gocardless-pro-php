<?php

namespace GoCardlessPro\Core\Exception;

class ApiException extends GoCardlessProException
{
    /**
     * @var \Exception $error raw error object
     * @var int $http_status The http status response number.
     */
    public $api_error;

    /**
     * @param object $error JSON decoded GoCardless API error
     */
    public function __construct($error)
    {
        $this->api_error = $error;
        parent::__construct($this->getErrorMessage(), $this->api_error->code);
    }

    /**
     * Factory for GoCardlessPro and it's subclasses.
     * @return InvalidApiUsageException|InvalidStateException|ValidationFailedException
     */
    public static function getErrorForType($error_type)
    {
        switch($error_type) {
        case 'invalid_api_usage':
            return 'InvalidApiUsageException';
        case 'invalid_state':
            return 'InvalidStateException';
        case 'validation_failed':
            return 'ValidationFailedException';
        }

        throw new GoCardlessProException('Invalid error type ' . $error_type);
    }

    public function getType()
    {
        return $this->api_error->type;
    }

    public function getErrors()
    {
        if (property_exists($this->api_error, 'errors')) {
            return $this->api_error->errors;
        }

        return array();
    }

    public function getDocumentationUrl()
    {
        return $this->api_error->documentation_url;
    }

    public function getRequestId()
    {
        return $this->api_error->request_id;
    }

    protected function getErrorMessage()
    {
        if (!is_array($this->getErrors())) {
            return $this->api_error->message;
        }

        $error_messages = array_map(array($this, 'extractErrorMessage'), $this->getErrors());
        $error_messages = array_filter(
            $error_messages,
            function ($m) {
                return $m != $this->api_error->message;
            }
        );

        if (count($error_messages) > 0) {
            return $this->api_error->message . ' (' . implode($error_messages, ", ") . ')';
        } else {
            return $this->api_error->message;
        }
    }

    protected function extractErrorMessage($error)
    {
        return $error->message;
    }

}
