<?php

namespace spec\Raspberry\Sensors;

use Mockery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DHT11Spec extends ObjectBehavior
{
    private $shell;

    private $scriptPath = 'scripts';
    private $scriptName = 'dht11.py';

    function let() {
        $shell = Mockery::mock('MrRio\ShellWrap');
        $this->beConstructedWith($this->scriptName, $this->scriptPath, $shell);

        $this->shell = $shell;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Sensors\DHT11');
    }

    function it_gets_sensor_id() {
        $this->getId()->shouldReturn('DHT11');
    }

    function it_gets_sensor_name() {
        $this->getName()->shouldReturn('DHT11');
    }

    function it_sets_script_name() {
        $this->getScriptName()->shouldReturn($this->scriptName);
    }

    function is_sets_script_path() {
        $this->getScriptPath()->shouldReturn($this->scriptPath);
    }

    function it_returns_reading() {
        $this->shell->shouldReceive('sudo')->once()
            ->with(['S' => true], 'python', $this->scriptPath . $this->scriptName)
            ->andReturn('26|40');

        $this->read()->shouldReturn([
            'temperature' => '26',
            'humidity' => '40'
        ]);
    }
}
