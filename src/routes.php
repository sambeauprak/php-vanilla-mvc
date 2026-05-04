<?php


use MiladRahimi\PhpRouter\Router;

$router = Router::create();

require_once __DIR__ . "/controllers/PageController.php";
require_once __DIR__ . "/controllers/DatabaseController.php";

$pageController = new PageController();

// $pageController est une nouvelle instance de la class PageController
// objet

$router->get('/', $pageController->index());
$router->get('/add', $pageController->add());
$router->post('/submit', $pageController->submit());

$router->dispatch();
