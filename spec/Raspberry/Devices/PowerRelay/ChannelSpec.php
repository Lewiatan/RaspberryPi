<?php

namespace spec\Raspberry\Devices\PowerRelay;

use Mockery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChannelSpec extends ObjectBehavior
{
    /**
     * @var Mockery $pin
     */
    private $pin;

    function let() {
        $pin = Mockery::mock('Raspberry\GPIO\Pin');
        $pin->shouldReceive('mode')->once()->with('out');
        $pin->shouldReceive('state')->once();

        $this->beConstructedWith($pin);

        $this->pin = $pin;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Devices\PowerRelay\Channel');
    }

    function it_throws_excpetion_when_wrong_pin_provided() {
        $this->beConstructedWith('string');
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_trhows_exception_when_wrong_object_provided() {
        $this->beConstructedWith(new \stdClass());
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_turns_channel_on() {
        $this->pin->shouldReceive('state')->once()->with(0);

        $this->on();
    }

    function it_turns_channel_off() {
        $this->pin->shouldReceive('state')->once()->with(1);

        $this->off();
    }

    function it_gets_state_of_channel() {
        $this->pin->shouldReceive('state')->once()->with(0);
        $this->pin->shouldReceive('state')->twice()->withNoArgs()->andReturn(0);
        $this->pin->shouldReceive('state')->once()->with(1);
        $this->pin->shouldReceive('state')->twice()->withNoArgs()->andReturn(1);

        $this->on();

        $this->isOn()->shouldReturn(true);
        $this->isOff()->shouldReturn(false);

        $this->off();

        $this->isOn()->shouldReturn(false);
        $this->isOff()->shouldReturn(true);
    }

    function it_toggles_state() {
        $this->pin->shouldReceive('state')->once()->with(1);
        $this->pin->shouldReceive('state')->once()->with(0);
        $this->pin->shouldReceive('state')->once()->with(1);

        $this->off();

        $this->isOff()->shouldReturn(true);
        $this->toggle();
        $this->isOff()->shouldReturn(false);
        $this->toggle();
        $this->isOff()->shouldReturn(true);
    }
}
