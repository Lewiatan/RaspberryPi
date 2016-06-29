<?php namespace Raspberry\Sensors;

use Raspberry\Interfaces\Sensor;
use MrRio\ShellWrap as sh;
use Raspberry\Pi;

class DHT11 implements Sensor
{

    private $scriptName = 'dht11.py';
    private $scriptPath;

    public function __construct() {
        $this->scriptPath = Pi::instance()->getDirectory();
    }

    public function read()
    {
        $read = sh::sudo('python', $this->scriptPath . '/' . $this->scriptName);

        $reading = explode('|', $read);

        return [
            'temperature' => $reading[0],
            'humidity' => $reading[1]
        ];
    }
}