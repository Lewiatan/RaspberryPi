<?php namespace Raspberry\Devices;

use Raspberry\Devices\PowerRelay\Channel;
use Raspberry\Interfaces\Device;

class PowerRelay implements Device
{
    protected $AVAILABLE_CHANNELS_COUNT = [1, 2, 4, 8];

    protected $totalChannels;

    protected $channels = [];

    public function __construct($totalChannels = null) {
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
        $this->checkMaximumChannels($channels);

        foreach ($channels as $i => $channel) {
            if ( ! $this->isValidChannel($channel)) {
                throw new \InvalidArgumentException('Wrong channel provided');
            }

            if (is_int($channel)) {
                $channel = $this->makeChannel($channel);
            }

            $this->channels[$i] = $channel;
        }

        return $this;
    }

    public function getChannels()
    {
        return $this->channels;
    }

    public function channel($channel)
    {
        $this->checkChannel($channel);

        return $this->channels[$channel];
    }

    /**
     * @param $channel
     * @return Channel
     */
    protected function makeChannel($channel)
    {
        return new Channel($channel);
    }

    protected function checkChannel($channel)
    {
        if ( ! array_key_exists($channel, $this->channels)) {
            throw new \InvalidArgumentException('Provided channel does not exists');
        }
    }

    /**
     * @param $channel
     * @return bool
     */
    protected function isValidChannel($channel)
    {
        return is_int($channel) || (is_object($channel) && $channel instanceof Channel);
    }

    protected function checkMaximumChannels($channels)
    {
        if (count($channels) > $this->totalChannels) {
            throw new \InvalidArgumentException('You\'re trying to assing more channels than is available.');
        }
    }


}