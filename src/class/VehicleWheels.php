<?php

class VehicleWheels extends Vehicle
{
    private $wheelsCount;

    public function __construct($engine, $color, $wheelsCount)
    {
        parent::__construct($engine, $color);
        $this->wheelsCount = $wheelsCount;
    }

    public function caracteristics()
    {
        parent::caracteristics();
        echo ", j'ai " . $this->wheelsCount . " roues";
    }
}