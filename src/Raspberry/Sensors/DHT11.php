<?php namespace Raspberry\Sensors;

use MrRio\ShellWrap;
use Raspberry\Interfaces\Sensor;
use MrRio\ShellWrap as sh;
use Raspberry\Pi;

class DHT11 implements Sensor
{
    private $id = 'DHT11';
    private $name = 'DHT11';
    private $scriptName = 'dht11.py';
    private $scriptPath;
    private $shell;

    public function __construct($scriptName = null, $scriptPath = null, ShellWrap $shell = null) {
        if ($shell === null) {
            $shell = new ShellWrap();
        }

        $this->shell = $shell;

        if ($scriptPath === null) {
            $scriptPath = Pi::instance()->getDirectory() . '/Python/';
        }

        $this->scriptPath = $scriptPath;

        if ($scriptName !== null) {
            $this->scriptName = $scriptName;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getScriptName()
    {
        return $this->scriptName;
    }

    public function getScriptPath()
    {
        return $this->scriptPath;
    }

    public function read()
    {
        $read = $this->shell->sudo(['S' => true], 'python', $this->scriptPath . $this->scriptName);

        $reading = explode('|', $read);

        return [
            'temperature' => $reading[0],
            'humidity' => $reading[1]
        ];
    }
}