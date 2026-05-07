<?php

use App\Controllers\PageController;
use MiladRahimi\PhpRouter\Router;

$router = Router::create();


// Affichage à l'écran
$router->get('/', [PageController::class, "index"]);
$router->get('/add', [PageController::class, "add"]);
$router->get('/edit/{id}', [PageController::class, "edit"]);

$router->get('/pages/{slug}', [PageController::class, "show"]);


// Traitement des formulaires
$router->post('/update/{id}', [PageController::class, "update"]);
$router->post('/submit', [PageController::class, "submit"]);
$router->get('/delete/{id}', [PageController::class, "delete"]);

$router->dispatch();
