<?php

namespace spec\Raspberry\Mocks\Sensors;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DS18B20Spec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Mocks\Sensors\DS18B20');
    }

    function it_gets_sensor_id() {
        $this->getName()->shouldReturn('DS18B20MOCK');
    }

    function it_gets_sensor_name() {
        $this->getName()->shouldReturn('DS18B20MOCK');
    }

    function it_returns_reading() {
        $this->read()->shouldReturn(25);
    }
}
