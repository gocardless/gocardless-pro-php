<?php

namespace GoCardlessPro\Core\Mocks;

class MockResource extends \GoCardlessPro\Resources\Base
{
    public function id()
    {
        return $this->data['id'];
    }

    public function name()
    {
        return $this->data['name'];
    }
}
