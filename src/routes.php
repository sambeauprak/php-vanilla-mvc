<?php


use MiladRahimi\PhpRouter\Router;

$router = Router::create();

require_once __DIR__ . "/controllers/PageController.php";

$router->get('/', indexPage($twig));
$router->get('/bio', bioPage($twig));
$router->get('/projects', projectsPage($twig));
$router->get('/contact', contactPage($twig));

$router->dispatch();