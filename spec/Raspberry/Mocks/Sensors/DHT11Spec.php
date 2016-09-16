<?php

namespace spec\Raspberry\Mocks\Sensors;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DHT11Spec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Mocks\Sensors\DHT11');
    }

    function it_gets_sensor_id() {
        $this->getId()->shouldReturn('DHT11MOCK');
    }

    function it_gets_sensor_name() {
        $this->getName()->shouldReturn('DHT11MOCK');
    }

    function it_returns_reading() {
        $this->read()->shouldReturn([
            'temperature' => 25,
            'humidity' => 50
        ]);
    }
}
