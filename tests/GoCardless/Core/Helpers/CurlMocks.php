<?php

namespace GoCardless\Core;

function curl_setopt($a, $b, $c)
{
    assert($a === 'lol');
    Helpers\StaticStorage::addCall('curl_setopt');
    Helpers\StaticStorage::setOpt($b, $c);
    return true;
}

function curl_init()
{
    Helpers\StaticStorage::addCall('curl_init');
    return 'lol';
}

function curl_close($handle)
{
    assert($handle === 'lol');
    Helpers\StaticStorage::addCall('curl_close');
}

function curl_exec($handle)
{
    assert($handle === 'lol');
    Helpers\StaticStorage::addCall('curl_exec');
    return Helpers\StaticStorage::getRetVal('exec');
}

function curl_getinfo($handle, $info)
{
    assert($handle === 'lol');
    Helpers\StaticStorage::addCall('curl_getinfo');
    return Helpers\StaticStorage::getRetVal($info);
}
