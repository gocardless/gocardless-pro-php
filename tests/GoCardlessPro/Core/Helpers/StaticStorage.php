<?php

namespace GoCardlessPro\Core\Helpers;

class StaticStorage
{
    public static $calls = array();
    public static $opts  = array();
    public static $ret   = array();
    public static $calls_back = array();
    
    public static function setup()
    {
        require_once(__DIR__ . '/CurlMocks.php');
    }
    public static function tearDown()
    {
        self::$calls = array();
        self::$opts = array();
        self::$ret = array();
        self::$calls_back = array();
    }
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
        if (isset(self::$calls_back[$fn]) && !empty(self::$calls_back[$fn])) {
            foreach (self::$calls_back[$fn] as $call) {
                call_user_func_array($call, array());
            }
        }
    }
    public static function onCall($key, $cb)
    {
        self::$calls_back[$key][] = $cb;
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
