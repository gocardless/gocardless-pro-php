<?php

namespace GoCardlessPro\Core\Mocks;

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
