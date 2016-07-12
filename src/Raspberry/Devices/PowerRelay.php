<?php namespace Raspberry\Devices;

use Raspberry\GPIO;
use Raspberry\GPIO\Pin;
use Raspberry\Interfaces\Device;

class PowerRelay implements Device
{
    const ON = GPIO::LOW;
    const OFF = GPIO::HI;

    private $AVAILABLE_CHANNELS_COUNT = [1, 2, 4, 8];

    private $totalChannels;

    private $channels = [];

    private $pin;

    public function __construct($totalChannels = null, Pin $pin = null) {
        if ($pin === null) {
            $pin = new Pin(0);
        }

        $this->pin = $pin;

        if ($totalChannels !== null) {
            $this->setTotalChannels($totalChannels);
        }
    }

    /**
     * @param mixed $totalChannels
     * @return $this
     */
    public function setTotalChannels($totalChannels)
    {
        if ( ! in_array($totalChannels, $this->AVAILABLE_CHANNELS_COUNT)) {
            throw new \InvalidArgumentException('Wrong number of channels.
            Channels available: ' . implode(', ', $this->AVAILABLE_CHANNELS_COUNT));
        }

        $this->totalChannels = $totalChannels;

        return $this;
    }

    public function getTotalChannels()
    {
        return $this->totalChannels;
    }

    /**
     * @param array $channels
     * @return $this
     */
    public function setChannels(array $channels)
    {
        foreach ($channels as $i => $pin) {
            if ( ! is_int($pin) && ! is_object($pin)) {
                throw new \InvalidArgumentException('Wrong pin provided');
            }

            if (is_int($pin)) {
                $pin = new $this->pin($pin);
            }

            $pin->mode(GPIO::OUT);

            $this->channels[$i] = $pin;
        }

        return $this;
    }

    public function getChannels()
    {
        return $this->channels;
    }

    public function on($channel)
    {
        $this->checkChannel($channel);

        $this->channels[$channel]->state(self::ON);

        return $this;
    }

    public function off($channel)
    {
        $this->checkChannel($channel);

        $this->channels[$channel]->state(self::OFF);

        return $this;
    }

    private function checkChannel($channel)
    {
        if ( ! array_key_exists($channel, $this->channels)) {
            throw new \InvalidArgumentException('Provided channel does not exists');
        }
    }


}