<?php

namespace spec\Raspberry;

use Raspberry\GPIO;
use \Mockery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GPIOSpec extends ObjectBehavior
{
    private $shell;

    function let() {
        $shell = Mockery::mock('MrRio\ShellWrap');
        $this->beConstructedWith($shell);

        $this->shell = $shell;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\GPIO');
    }

    function it_throws_exception_when_pin_is_not_an_integer() {
        $this->shouldThrow('\InvalidArgumentException')
            ->duringSetMode('string', GPIO::IN);

        $this->shouldThrow('\InvalidArgumentException')
            ->duringSetMode('1', GPIO::IN);
    }

    function it_throws_excpetion_when_mode_is_invalid() {
        $this->shouldThrow('\InvalidArgumentException')
            ->duringSetMode(26, GPIO::HI);

        $this->shouldThrow('\InvalidArgumentException')
            ->duringSetMode(26, 'test');

        $this->shouldThrow('\InvalidArgumentException')
            ->duringSetMode(26, 5);
    }

    function it_throws_excpetion_when_state_is_invalid() {
        $this->shouldThrow('\InvalidArgumentException')
            ->duringSetState(26, GPIO::IN);

        $this->shouldThrow('\InvalidArgumentException')
            ->duringSetState(26, 'test');

        $this->shouldThrow('\InvalidArgumentException')
            ->duringSetState(26, 5);
    }

    function it_sets_in_mode() {
        $this->shell->shouldReceive('gpio')->once()->with([
            'g' => 'mode 1 in'
        ]);

        $this->setMode(1, GPIO::IN);
    }

    function it_sets_out_mode() {
        $this->shell->shouldReceive('gpio')->once()->with([
            'g' => 'mode 1 out'
        ]);

        $this->setMode(1, GPIO::OUT);
    }

    function it_sets_hi_state() {
        $this->shell->shouldReceive('gpio')->once()->with([
            'g' => 'write 1 1'
        ]);

        $this->setState(1, GPIO::HI);
    }

    function it_sets_low_state() {
        $this->shell->shouldReceive('gpio')->once()->with([
            'g' => 'write 1 0'
        ]);

        $this->setState(1, GPIO::LOW);
    }

    function it_reads_state() {
        $this->shell->shouldReceive('gpio')->once()->with([
            'g' => 'read 1'
        ]);

        $this->readState(1);
    }
}
