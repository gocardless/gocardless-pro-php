<?php

namespace GoCardlessPro\Services\Mocks;

use \GoCardlessPro\Services\Base as Base;

class BaseImpl extends Base
{
    public function envelopeKey()
    {
        return 'envelopeKey';
    }
    public function resourceClass()
    {
        return '\GoCardlessPro\Resources\Customer';
    }
    public function proxySubUrl($url, $subs)
    {
        return $this->sub_url($url, $subs);
    }
    public function proxyMakeRequest($method, $uri, $options, $headers)
    {
        return $this->make_request($method, $uri, $options, $headers);
    }
}
