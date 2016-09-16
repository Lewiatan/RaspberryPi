<?php

namespace spec\Raspberry\Mocks;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Raspberry\GPIO;

class GPIOSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Mocks\GPIO');
    }

    function it_sets_mode()
    {
        $this->setMode(1, GPIO::IN);
        $this->setMode(1, GPIO::OUT);
    }

    function it_sets_state()
    {
        $this->setState(1, GPIO::LOW);
        $this->setState(1, GPIO::HI);
    }

    function it_reads_state()
    {
        $this->readState(1)->shouldReturn(GPIO::LOW);

        $this->setState(1, GPIO::HI);
        $this->readState(1)->shouldReturn(GPIO::HI);
    }
}
