<?php

require_once __DIR__ . "/Vehicle.php";
require_once __DIR__ . "/VehicleAir.php";
require_once __DIR__ . "/VehicleWheels.php";
require_once __DIR__ . "/Car.php";
require_once __DIR__ . "/Airplane.php";
require_once __DIR__ . "/Moto.php";

$vehicleWheels = new VehicleWheels("Mercedes", "rouge", 4);

$vehicleWheels->caracteristics();