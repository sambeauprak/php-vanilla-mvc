<?php


use MiladRahimi\PhpRouter\Router;

$router = Router::create();

require_once __DIR__ . "/controllers/PageController.php";

$pageController = new PageController();

// $pageController est une nouvelle instance de la class PageController
// objet

$router->get('/', $pageController->index());
$router->get('/bio', $pageController->bio());
$router->get('/projects', $pageController->projects());
$router->get('/contact', $pageController->contact());

$router->dispatch();