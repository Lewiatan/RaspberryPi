<?php

require 'vendor/autoload.php';

use Raspberry\GPIO;
use Raspberry\GPIO\Pin;
use Raspberry\Pi;

var_dump(trim((new Pi())->execute('echo test')));


/* Proof of concept */

$gpio = new GPIO();
$gpio->setMode(26, GPIO::IN)->setState(26, GPIO::HI);

$pin26 = new Pin(26);
$pin26->mode(GPIO::OUT)->state(GPIO::HI)->read();

$pi = new Pi(); // make it singleton?
$pi->registerScript('script1', 'script1.py');
$pi->registerScript('script2', function() {
    // do stuff
});

// scrip class should extend abstract of implement interface
$pi->registerScript('script3', 'SomeAwesomeScriptClass');

$pi->runScript('script1');
$pi->runScript('script2');
$pi->runScript('script3');


$pr = new \Raspberry\Devices\PowerRelay();
$pr->setTotalChannels(4)->setChannels([1, 2, 3, 4]);