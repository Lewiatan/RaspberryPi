<?php

namespace Raspberry\GPIO;

use Raspberry\GPIO;

class Pin
{
    protected $pin;
    protected $state;
    protected $mode;

    public function __construct($pin, GPIO $gpio = null)
    {
        if ( ! $gpio) {
            $gpio = new GPIO();
        }

        $this->gpio = $gpio;
        $this->pin = $pin;

        $this->state(GPIO::LOW)->mode(GPIO::OUT);

        return $this;
    }

    public function getPin()
    {
        return $this->pin;
    }

    public function mode($mode = null)
    {
        if ($mode === null) {
            return $this->mode;
        }

        $this->gpio->setMode($this->pin, $mode);
        $this->mode = $mode;

        return $this;
    }

    public function state($state = null)
    {
        if ($state === null) {
            return $this->state;
        }

        $this->gpio->setState($this->pin, $state);
        $this->state = $state;

        return $this;
    }

    public function read()
    {
        return $this->gpio->readState($this->pin);
    }

    public function toggleState()
    {
        $this->state((int) ! $this->state);
    }
}