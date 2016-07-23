<?php namespace Raspberry;

use MrRio\ShellWrap as sh;

class DS18B20Detector
{
    private static $path = '/sys/bus/w1/devices/w1_bus_master1/';
    private static $pattern = '28-*/';

    public static function detect()
    {
        return self::getDevices();
    }

    private static function getDevices()
    {
        return sh::ls([
            'd' => self::$path . self::$pattern
        ]);
    }
}