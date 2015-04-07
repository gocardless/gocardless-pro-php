<?php

namespace GoCardless\Core;

class Response
{
    private $responseBody;
    private $responseContentType;
    private $responseStatus;

    public function __construct($responseBody, $responseStatus, $responseContentType)
    {
        $this->responseBody = $responseBody;
        $this->responseContentType = $responseContentType;
        $this->responseStatus = $responseStatus;
        if ($this->isError()) {
            $this->handleError();
        }
    }

    public function handleError()
    {
        $error = $this->isJson() ? $this->jsonBody() : $this->rawBody();
        throw Error\GoCardlessError::makeApiError($error, $this->status());
    }

    public function setUnwrapJson($key)
    {
        $this->unwrapJson = $key;
    }

    public function contentType()
    {
        return $this->responseContentType;
    }

    public function status()
    {
        return $this->responseStatus;
    }

    public function body()
    {
        return ($this->isJson() ? $this->jsonBody() : $this->rawBody());
    }

    public function isJson()
    {
        return (strpos($this->responseContentType, 'application/json') === 0);
    }

    public function isError()
    {
        return ($this->responseStatus >= 400);
    }

    public function response()
    {
        if (!isset($this->unwrapJson)) {
            throw new \Exception("UnwrapJSON needs to be set before getting response body");
        }
        return $this->jsonBody()->{$this->unwrapJson};
    }

    public function meta()
    {
        return $this->jsonBody()->meta;
    }

    public function limit()
    {
        return $this->jsonBody()->meta->limit;
    }

    public function jsonBody()
    {
        if (!isset($this->jsonBodyData)) {
            $this->jsonBodyData = json_decode($this->responseBody);
        }
        return $this->jsonBodyData;
    }

    public function rawBody()
    {
        return $this->responseBody;
    }
}
