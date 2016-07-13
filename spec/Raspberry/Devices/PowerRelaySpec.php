<?php

namespace spec\Raspberry\Devices;

use Mockery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PowerRelaySpec extends ObjectBehavior
{
    function let() {
        $this->beConstructedWith(2);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Devices\PowerRelay');
    }

    function it_sets_total_channels() {
        $this->getTotalChannels()->shouldBe(2);

        $this->setTotalChannels(4);

        $this->getTotalChannels()->shouldBe(4);
    }

    function it_throws_exception_when_wrong_channels_provided() {
        $this->shouldThrow('InvalidArgumentException')->during('setTotalChannels', [3]);
    }

    function it_throws_exception_when_assigning_more_channels_than_available() {
        $this->shouldThrow('InvalidArgumentException')->during('setChannels', [range(1, 5)]);
    }

    function it_detects_wrong_channel_when_passed() {
        $pin = Mockery::mock('Raspberry\GPIO\Pin');

        $this->shouldThrow('InvalidArgumentException')->during('setChannels', [[$pin]]);
    }

    function it_sets_and_returns_channels() {
        $channels = [];
        foreach (range(1, 2) as $i) {
            $channels[] = Mockery::mock('Raspberry\Devices\PowerRelay\Channel');
        }

        $this->setChannels($channels);

        $this->getChannels()->shouldBe($channels);

        $this->channel(0)->shouldBe($channels[0]);
        $this->channel(1)->shouldBe($channels[1]);
    }
}
