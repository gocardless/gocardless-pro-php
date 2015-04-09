<?php

namespace GoCardless\Core\Mocks;

class ResourceHolder
{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function data()
    {
        return $this->data;
    }
}
