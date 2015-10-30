<?php

namespace GoCardlessPro\Core\Exception;

class ValidationFailedException extends ApiException
{
    protected function extractErrorMessage($error)
    {
        return $error->field . ' ' . $error->message;
    }
};
