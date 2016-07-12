<?php namespace Raspberry\Sensors;

use MrRio\ShellWrap;
use Raspberry\Interfaces\Sensor;
use MrRio\ShellWrap as sh;

class DS18B20 implements Sensor
{
    private $path = '/sys/bus/w1/devices/w1_bus_master1/';
    private $id = '';

    public function __construct($id, ShellWrap $shell = null) {
        if ($shell === null) {
            $shell = new ShellWrap();
        }

        $this->id = $id;

        $this->shell = $shell;
    }

    public function getId()
    {
        return $this->id;
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
        return $this->shell->cat($this->path . $this->id . '/w1_slave');
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