<?php namespace Raspberry\Devices\PowerRelay;

use Raspberry\GPIO;
use Raspberry\GPIO\Pin;

class Channel
{
    const ON = GPIO::LOW;
    const OFF = GPIO::HI;

    private $pin;
    private $state;

    public function __construct($pin, $initialState = null)
    {
        if (! $this->isValidPin($pin)) {
            throw new \InvalidArgumentException('Wrong pin provided');
        }

        if (is_int($pin)) {
            $pin = new Pin($pin);
        }

        $pin->mode(GPIO::OUT);

        $this->pin = $pin;

        if ($initialState) {
            $this->state($initialState);
        } else {
            $this->state = $this->state();
        }
    }

    public function on()
    {
        $this->state(self::ON);

        return $this;
    }

    public function off()
    {
        $this->state(self::OFF);

        return $this;
    }

    public function isOn()
    {
        return $this->state == self::ON;
    }

    public function isOff()
    {
        return ! $this->isOn();
    }

    public function toggle()
    {
        $newState = ($this->state == self::ON)
            ? self::OFF
            : self::ON;

        $this->state($newState);
    }

    /**
     * @param $state
     * @return $this
     */
    private function state($state)
    {
        $this->state = $state;
        $this->pin->state($state);
    }

    /**
     * @param $pin
     * @return bool
     */
    private function isValidPin($pin)
    {
        return (is_int($pin) || (is_object($pin) && $pin instanceof Pin));
    }
}