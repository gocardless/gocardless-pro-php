<?php

namespace GoCardless\Services\Mocks;

use \GoCardless\Services\Base as Base;

class BaseImpl extends Base
{
    public function envelopeKey()
    {
        return 'envelopeKey';
    }
    public function resourceClass()
    {
        return '\GoCardless\Resources\Customer';
    }
    public function proxySubUrl($url, $subs)
    {
        return $this->subUrl($url, $subs);
    }
}
