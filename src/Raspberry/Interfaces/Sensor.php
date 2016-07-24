<?php namespace Raspberry\Interfaces;

interface Sensor
{
    public function read();

    public function getId();

    public function getName();
}