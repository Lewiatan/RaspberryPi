<?php

namespace Raspberry\GPIO;

use Raspberry\GPIO;

class Pin
{
    protected $pin;

    public function __construct($pin, GPIO $gpio = null)
    {
        if ( ! $gpio) {
            $gpio = new GPIO();
        }

        $this->gpio = $gpio;
        $this->pin = $pin;

        return $this;
    }

    public function getPin()
    {
        return $this->pin;
    }

    public function mode($mode)
    {
        $this->gpio->setMode($this->pin, $mode);

        return $this;
    }

    public function state($state)
    {
        $this->gpio->setState($this->pin, $state);

        return $this;
    }

    public function read()
    {
        return $this->gpio->readState($this->pin);
    }
}