<?php

namespace GoCardlessPro\Support;

trait TestFixtures
{
    protected function buildFixturePath($name)
    {
        return 'tests/fixtures/' . $name . '.json';
    }

    protected function loadFixture($name)
    {
        $path = $this->buildFixturePath($name);
        return fread(fopen($path, 'r'), filesize($path));
    }

    protected function loadJsonFixture($name)
    {
        return json_decode($this->loadFixture($name));
    }
}
