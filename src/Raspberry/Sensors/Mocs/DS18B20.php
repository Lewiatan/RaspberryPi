<?php namespace Raspberry\Sensors\Mocs;

use Raspberry\Interfaces\Sensor;

class DS18B20 implements Sensor
{

    public function read()
    {
        return 25;
    }

    public function getId()
    {
        return 'DS18B20MOCK';
    }

    public function getName()
    {
        return 'DS18B20MOCK';
    }
}