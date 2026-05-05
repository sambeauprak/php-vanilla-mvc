<?php

use App\Controllers\PageController;
use MiladRahimi\PhpRouter\Router;

$router = Router::create();



$router->get('/', [PageController::class, "index"]);
$router->get('/add', [PageController::class, "add"]);
$router->post('/submit', [PageController::class, "submit"]);

$router->dispatch();
