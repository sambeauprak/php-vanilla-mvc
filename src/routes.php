<?php

use App\Controllers\BlockController;
use App\Controllers\PageController;
use MiladRahimi\PhpRouter\Router;

$router = Router::create();


/**
 * Routes pour les pages
 */

// Affichage à l'écran
$router->get('/', [PageController::class, "index"]);
$router->get('/add', [PageController::class, "add"]);
$router->get('/edit/{id}', [PageController::class, "edit"]);
$router->get('/pages/{slug}', [PageController::class, "show"]);
// Traitement des formulaires
$router->post('/update/{id}', [PageController::class, "update"]);
$router->post('/submit', [PageController::class, "submit"]);
$router->get('/delete/{id}', [PageController::class, "delete"]);


/**
 * Routes pour les blocks
 */

// Affichage à l'écran
$router->get('/blocks', [BlockController::class, "index"]);
$router->get('/blocks/add', [BlockController::class, "add"]);
$router->get('/blocks/edit/{id}', [BlockController::class, "edit"]);
$router->get('/blocks/show/{id}', [BlockController::class, "show"]);
// Traitement des formulaires
$router->post('/blocks/update/{id}', [BlockController::class, "update"]);
$router->post('/blocks/submit', [BlockController::class, "submit"]);
$router->get('/blocks/delete/{id}', [BlockController::class, "delete"]);

$router->dispatch();
