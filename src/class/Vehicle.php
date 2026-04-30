<?php

class Vehicle
{
    private $engine;
    private $color;

    public function __construct($engine, $color)
    {
        $this->engine = $engine;
        $this->color = $color;
    }

    protected function caracteristics()
    {
        echo "Moteur " . $this->engine . ", couleur : " . $this->color;
    }
}