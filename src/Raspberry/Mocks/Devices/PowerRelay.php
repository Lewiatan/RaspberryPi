<?php namespace Raspberry\Mocks\Devices;

use Raspberry\Devices\PowerRelay\Channel;
use Raspberry\GPIO\Pin;
use Raspberry\Mocks\GPIO;

class PowerRelay extends \Raspberry\Devices\PowerRelay
{
    /**
     * @param $channel
     * @return Channel
     */
    protected function makeChannel($channel)
    {
        return new Channel(new Pin($channel, new GPIO()));
    }

}