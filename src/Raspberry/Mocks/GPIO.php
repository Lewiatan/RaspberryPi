<?php namespace Raspberry\Mocks;

class GPIO extends \Raspberry\GPIO
{
    private $pins = [];

    public function __construct(ShellWrap $shell = null) {}

    public function setMode($pin, $mode)
    {
        $this->checkPin($pin);
        $this->checkMode($mode);

        $this->pins[$pin] = ['mode' => $mode];

        return $this;
    }

    public function setState($pin, $state)
    {
        $this->checkPin($pin);
        $this->checkState($state);

        $this->pins[$pin] = ['state' => $state];

        return $this;
    }

    public function readState($pin)
    {
        $this->checkPin($pin);

        if ( ! isset($this->pins[$pin]['state'])) {
            return GPIO::LOW;
        }

        return $this->pins[$pin]['state'];
    }
}