<?php

namespace GoCardlessPro\Core\Mocks;

class TestResource
{
    public $pages;
    public function __construct($pages)
    {
        $this->pages = $pages;
    }
    public function data()
    {
        return $this->pages;
    }
    public function __call($name, $args)
    {
        if ($name == 'list') {
            return $this->do_list($args[0]);
        }
        return false;
    }
    public function do_list($options)
    {
        if (isset($options['after']) && isset($this->pages[$options['after']])) {
            return $this->pages[$options['after']];
        }
        if (isset($options['before']) && isset($this->pages[$options['before']])) {
            return $this->pages[$options['before']];
        }
    }
}
