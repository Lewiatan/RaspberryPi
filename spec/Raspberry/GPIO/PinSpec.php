<?php

namespace spec\Raspberry\GPIO;

use Mockery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Raspberry\GPIO;

/**
 * @property \Raspberry\GPIO gpio
 */
class PinSpec extends ObjectBehavior
{
    private $gpio;

    private $pin = 1;

    function let() {
        $this->gpio = Mockery::mock('Raspberry\GPIO');
        $this->gpio->shouldReceive('readState')->with($this->pin);
        $this->gpio->shouldReceive('setMode')->with($this->pin, 'out');

        $this->beConstructedWith($this->pin, $this->gpio);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\GPIO\Pin');
    }

    function it_sets_pin() {
        $this->getPin()->shouldBe(1);
    }

    function it_should_be_initialized_with_current_state() {
        $this->gpio = Mockery::mock('Raspberry\GPIO');
        $this->gpio->shouldReceive('readState')->with($this->pin)->andReturn(1);
        $this->gpio->shouldReceive('setMode')->with($this->pin, 'out');

        $this->beConstructedWith($this->pin, $this->gpio);

        $this->state()->shouldBe(1);
    }


    function it_sets_low_state() {
        $this->gpio->shouldReceive('setState')->with($this->pin, GPIO::LOW)->andReturnSelf();

        $this->state(GPIO::LOW);
    }

    function it_sets_hi_state() {
        $this->gpio->shouldReceive('setState')->with($this->pin, GPIO::HI)->andReturnSelf();

        $this->state(GPIO::HI);
    }

    function it_returns_state() {
        $this->gpio->shouldReceive('setState')->with($this->pin, GPIO::HI);

        $this->state(GPIO::HI);
        $this->state()->shouldBe(GPIO::HI);
    }

    function it_sets_in_mode() {
        $this->gpio->shouldReceive('setMode')->with($this->pin, GPIO::IN)->andReturnSelf();

        $this->mode(GPIO::IN);
    }

    function it_sets_out_mode() {
        $this->gpio->shouldReceive('setMode')->with($this->pin, GPIO::OUT)->andReturnSelf();

        $this->mode(GPIO::OUT);
    }

    function it_returns_mode() {
        $this->gpio->shouldReceive('setMode')->with($this->pin, GPIO::IN);

        $this->mode()->shouldBe(GPIO::OUT);
        $this->mode(GPIO::IN);
        $this->mode()->shouldBe(GPIO::IN);
    }

    function it_reads_state() {
        $this->gpio->shouldReceive('readState')->with($this->pin);

        $this->read();
    }

    function it_toggles_state() {
        $this->gpio->shouldReceive('setState')->once()->with(1, 1);
        $this->gpio->shouldReceive('setState')->once()->with(1, 0);

        $this->toggleState();
        $this->state()->shouldBe(1);

        $this->toggleState();
        $this->state()->shouldBe(0);

    }
}
