<?php

namespace spec\Raspberry;

use Mockery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Raspberry\Scripts\ExampleScript;

class PiSpec extends ObjectBehavior
{
    function let() {
        $this->beConstructedThrough('instance');
    }

    function letGo() {
        $this->destroy();
    }

    static function insance() {
        return \Raspberry\Pi::instance();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Raspberry\Pi');
    }

    function it_registers_scripts() {
        $this->registerScript('test', function() {});
    }

    function it_gets_all_scripts() {
        $closure = function() {};

        $this->registerScript('test', $closure);
        $this->registerScript('test2', $closure);

        $this->getScripts()->shouldReturn([
            'test' => $closure,
            'test2' => $closure
        ]);
    }

    public function getsOneScript()
    {
        $script = function() {};

        $this->registerScript('test', $script);

        $this->getScript('test')->shouldBe($script);
    }

    function it_registers_script_class() {
        $script = Mockery::mock('Raspberry\Interfaces\Script');
        $this->registerScript('MockedScript', $script);

        $instance = new ExampleScript();
        $this->registerScript('ExampleScript', 'Raspberry\Scripts\ExampleScript');

        $this->getScripts()->shouldBeLike([
            'MockedScript' => $script,
            'ExampleScript' => $instance
        ]);
    }

    function it_throws_exception_when_script_not_exits() {
        $this->shouldThrow('\InvalidArgumentException')
            ->duringRunScript('test');
    }

    function it_runs_registered_script_class() {
        $script = Mockery::mock('Raspberry\Interfaces\Script');
        $script->shouldReceive('run')->withNoArgs()->once();

        $this->registerScript('test', $script);
        $this->runScript('test');
    }

    function it_runs_registered_closure() {
        $this->registerScript('test', function() {
            return 'Closure has run';
        });

        $this->runScript('test')->shouldBe('Closure has run');
    }
}
