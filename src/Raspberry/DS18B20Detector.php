<?php namespace Raspberry;

use MrRio\ShellWrap as sh;

class DS18B20Detector
{
    private static $path = '/sys/bus/w1/devices/w1_bus_master1/';
    private static $pattern = '28-*/';

    public static function detect()
    {
        $devices = self::getDevices();
        return self::parseDevices($devices);
    }

    private static function getDevices()
    {
        return sh::ls('-d', self::$path . self::$pattern);
    }

    private static function parseDevices($devices)
    {
        $devices = str_replace([self::$path, '/'], '', $devices);
        $devices = explode(PHP_EOL, $devices);

        return array_filter($devices, function($item) { return strlen($item); });
    }


}