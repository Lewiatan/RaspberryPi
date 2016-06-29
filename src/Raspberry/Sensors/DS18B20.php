<?php namespace Raspberry\Sensors;

use Raspberry\Interfaces\Sensor;
use MrRio\ShellWrap as sh;

class DS18B20 implements Sensor
{
    private $path = '/sys/bus/w1/devices/w1_bus_master1/';
    private $id = '';

    public function __construct($id) {
        $this->id = $id;
    }

    public function read() {
        $reading = $this->getReading();

        return $this->parseReading($reading);
    }

    /**
     * @return string
     */
    private function getReading()
    {
        return sh::cat($this->path . $this->id . '/w1_slave');
    }

    /**
     * @param $reading
     * @return float
     */
    private function parseReading($reading)
    {
        return (substr($reading, -6) / 1000);
    }
}