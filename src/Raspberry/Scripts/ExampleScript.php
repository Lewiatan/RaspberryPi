<?php namespace Raspberry\Scripts;

use Raspberry\Interfaces\Script;

class ExampleScript implements Script
{

    public function run()
    {
        $pin = new Pin(26);
        $pin->mode(GPIO::OUT)->state(GPIO::LOW);
        sleep(1);
        $pin->state(GPIO::HI);
    }
}