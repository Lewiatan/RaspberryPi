<?php namespace Raspberry\Devices;

use Raspberry\Interfaces\Device;
use MrRio\ShellWrap as sh;

class DS18B20 implements Device
{
    private $path = '/sys/bus/w1/devices/w1_bus_master1/';
    private $id = '';

    public function __construct($id) {
        $this->id = $id;
    }

    public function read() {
        $cat = sh::cat($this->path . $this->id . '/w1_slave');

        return (substr($cat, -6) / 1000) . '*C';
    }
}