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
        $this->setup_request();
    }
    public function doSetOpt($opta, $optb)
    {
        $this->opts[$opta] = $optb;
    }
}
