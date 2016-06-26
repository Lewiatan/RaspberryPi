<?php

namespace spec\Raspberry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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

    function it_registers_script_class() {
        $this->registerScript('ExampleScript', 'Raspberry\Scripts\ExampleScript');

        $this->getScripts()->shouldReturn([
            'ExampleScript' => 'Raspberry\Scripts\ExampleScript'
        ]);
    }
}
