<?php

namespace GoCardlessPro\Core\Exception;

class MalformedResponseException extends GoCardlessProException
{
    const BODY_PREVIEW_MAX_LENGTH = 500;

    private $response;
    private $statusCode;

    public function __construct($message, $response, $statusCode = null)
    {
        $this->response = $response;
        $this->statusCode = $statusCode;
        parent::__construct(self::buildMessage($message, $response, $statusCode));
    }


    public function response()
    {
        return $this->response;
    }

    public function statusCode()
    {
        return $this->statusCode;
    }

    private static function buildMessage($message, $response, $statusCode)
    {
        $full = $message;
        if ($statusCode !== null) {
            $full .= ' (HTTP ' . $statusCode . ')';
        }
        $body = null;
        if (is_string($response)) {
            $body = $response;
        } elseif (is_object($response) && method_exists($response, 'getBody')) {
            $body = (string) $response->getBody();
        }
        if ($body !== null && $body !== '') {
            if (strlen($body) > self::BODY_PREVIEW_MAX_LENGTH) {
                $body = substr($body, 0, self::BODY_PREVIEW_MAX_LENGTH) . '...';
            }
            $full .= ': ' . $body;
        }
        return $full;
    }
}
