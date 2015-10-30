<?php

namespace GoCardlessPro\Core\Mocks;

class MockService
{
    private $pages;

    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    public function __call($name, $args)
    {
        if ($name == 'list') {
            return $this->_doList($args[0]);
        }
        return false;
    }

    private function _doList($options)
    {
        if (isset($options['params']['after'])) {
            return $this->pages[1];
        }

        return $this->pages[0];
    }
}
