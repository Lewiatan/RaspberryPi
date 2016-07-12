<?php

namespace spec\Raspberry\Devices;

use Mockery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PowerRelaySpec extends ObjectBehavior
{
    private $shell;
    private $pin;

    function let() {
        $shell = Mockery::mock('MrRio\ShellWrap');
        $pin = Mockery::mock('Raspberry\GPIO\Pin');

        $this->shell = $shell;
        $this->pin = $pin;

        $this->beConstructedWith(4, $pin);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Devices\PowerRelay');
    }

    function it_sets_total_channels() {
        $this->getTotalChannels()->shouldBe(4);

        $this->setTotalChannels(2);

        $this->getTotalChannels()->shouldBe(2);
    }

    function it_throws_exception_when_wrong_channels_provided() {
        $this->shouldThrow('InvalidArgumentException')->during('setTotalChannels', [3]);
    }

    function it_sets_and_returns_channels() {
        $pins = [];
        foreach (range(1, 4) as $i) {
            $pin = Mockery::mock('Raspberry\GPIO\Pin');
            $pin->shouldReceive('mode')->once();
            $pins[] = $pin;
        }

        $this->setChannels($pins);

        $this->getChannels()->shouldBe($pins);
    }

    function it_turns_channel_on() {
        $pin = Mockery::mock('Raspberry\GPIO\Pin');
        $pin->shouldReceive('mode')->once();
        $pin->shouldReceive('state')->once()->with(0);

        $this->setChannels([ 1 => $pin]);

        $this->on(1);
    }

    function it_turns_channel_off() {
        $pin = Mockery::mock('Raspberry\GPIO\Pin');
        $pin->shouldReceive('mode')->once();
        $pin->shouldReceive('state')->once()->with(1);

        $this->setChannels([ 1 => $pin]);

        $this->off(1);
    }
}
