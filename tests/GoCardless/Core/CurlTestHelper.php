<?php

namespace GoCardless\Core;


class OpenCurlWrapper extends CurlWrapper
{
    public function getHeaders()
    {
        return $this->headers;
    }

    public function testSetupRequest()
    {
        $this->setupRequest();
    }
    public function doSetOpt($opta, $optb)
    {
        $this->opts[$opta] = $optb;
    }
}

class StaticStorage
{
    static $calls = array();
    static $opts  = array();
    static $ret   = array();
    public static function setOpt($key, $val)
    {
        self::$opts[$key] = $val;
        return true;
    }
    public static function getOpt($key)
    {
        return self::$opts[$key];
    }
    public static function setRetVal($key, $val)
    {
        self::$ret[$key] = $val;
    }
    public static function getRetVal($key)
    {
        return self::$ret[$key];
    }
    public static function addCall($fn)
    {
        if (!isset(self::$calls[$fn])) {
          self::$calls[$fn] = 0;
        }
        self::$calls[$fn] += 1;
    }
    public static function getCalls($fn)
    {
        if (!isset(self::$calls[$fn])) {
            self::$calls[$fn] = 0;
        }
        return self::$calls[$fn];
    }
    public static function getKey($key)
    {
        return self::$opts[$key];
    }
    public static function reset()
    {
        self::$calls = array();
        self::$opts = array();
    }
}

function curl_setopt($a, $b, $c)
{
    StaticStorage::addCall('curl_setopt');
    StaticStorage::setOpt($b, $c);
    return true;
}

function curl_init()
{
    StaticStorage::addCall('curl_init');
    return 'lol';
}

function curl_close($handle)
{
    StaticStorage::addCall('curl_close');
}

function curl_exec($handle)
{
    StaticStorage::addCall('curl_exec');
    return StaticStorage::getRetVal('exec');
}

function curl_getinfo($handle, $info)
{
    StaticStorage::addCall('curl_getinfo');
    return StaticStorage::getRetVal($info);
}
