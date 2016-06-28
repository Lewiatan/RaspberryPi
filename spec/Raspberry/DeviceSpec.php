<?php

namespace spec\Raspberry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DeviceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Device');
    }
}
