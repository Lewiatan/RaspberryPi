<?php

namespace spec\Raspberry\Mocks\Devices;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PowerRelaySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(4);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Mocks\Devices\PowerRelay');
    }

    function it_makes_channels()
    {
        $this->setChannels([1, 2, 3, 4]);
    }
}
