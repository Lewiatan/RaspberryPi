<?php namespace Raspberry;

class Pi
{

    public function execute($command)
    {
        return shell_exec($command);
    }
}