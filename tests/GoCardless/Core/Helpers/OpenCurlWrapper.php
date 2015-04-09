<?php

namespace GoCardless\Core\Helpers;

class OpenCurlWrapper extends \GoCardless\Core\CurlWrapper
{
    public function getHeaders()
    {
        return $this->headers;
    }
    public function testSetupRequest()
    {
        $this->setupRequest();
    }
    public function doSetOpt($opta, $optb)
    {
        $this->opts[$opta] = $optb;
    }
}