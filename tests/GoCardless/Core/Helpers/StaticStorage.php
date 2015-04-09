<?php

namespace GoCardless\Core\Helpers;

class StaticStorage
{
    public static $calls = array();
    public static $opts  = array();
    public static $ret   = array();
	public static function setup()
	{
		require_once(__DIR__ . '/CurlMocks.php');
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
