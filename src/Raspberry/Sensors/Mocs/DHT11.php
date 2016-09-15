<?php namespace Raspberry\Sensors\Mocs;

use Raspberry\Interfaces\Sensor;

class DHT11 implements Sensor
{

    public function read()
    {
        return [
            'temperature' => 25,
            'humidity' => 50
        ];
    }

    public function getId()
    {
        return 'DHT11MOCK';
    }

    public function getName()
    {
        return 'DHT11MOCK';
    }
}