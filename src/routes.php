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

/**
 * Routes pour les variables (variants) d'un block
 */

// Affichage à l'écran
$router->get('/blocks/{block_id}/variables', [BlockController::class, "variables"]);
$router->get('/blocks/{block_id}/variables/add', [BlockController::class, "addVariable"]);
$router->get('/blocks/{block_id}/variables/edit/{variable_id}', [BlockController::class, "editVariable"]);
// Traitement des formulaires
$router->post('/blocks/{block_id}/variables/submit', [BlockController::class, "submitVariable"]);
$router->post('/blocks/{block_id}/variables/update/{variable_id}', [BlockController::class, "updateVariable"]);
$router->get('/blocks/{block_id}/variables/delete/{variable_id}', [BlockController::class, "deleteVariable"]);


/**
 * Routes pour les blocks d'une page
 */

// Affichage à l'écran
$router->get('/pages/{page_id}/blocks', [PageController::class, "manageBlocks"]);
// Traitement des formulaires
$router->post('/pages/{page_id}/blocks/add', [PageController::class, "addBlock"]);
$router->post('/pages/{page_id}/blocks/remove/{pb_id}', [PageController::class, "removeBlock"]);

$router->dispatch();
