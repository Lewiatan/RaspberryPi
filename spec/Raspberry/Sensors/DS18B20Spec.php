<?php

namespace spec\Raspberry\Sensors;

use Mockery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DS18B20Spec extends ObjectBehavior
{
    private $shell;

    function let() {
        $shell = Mockery::mock('MrRio\ShellWrap');
        $this->beConstructedWith(1, $shell);

        $this->shell = $shell;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Sensors\DS18B20');
    }

    function it_sets_proper_id() {
        $this->getId()->shouldBe(1);
    }

    function it_gets_sensor_name() {
        $this->getName()->shouldReturn('DS18B20');
    }

    function it_returns_reading() {
        $this->shell->shouldReceive('cat')->once()
            ->with('/sys/bus/w1/devices/w1_bus_master1/1/w1_slave')
            ->andReturn('this is the temperature: 26000');

        $this->read()->shouldReturn(26);
    }
}
