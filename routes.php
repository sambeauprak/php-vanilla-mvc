<?php


use MiladRahimi\PhpRouter\Router;

$router = Router::create();


$router->get('/', function () use ($twig) {
    return $twig->render('pages/index.html.twig');
});

$router->get('/bio', function () use ($twig) {
    return $twig->render('pages/bio.html.twig');
});

$router->get('/projects', function () use ($twig) {
    return $twig->render('pages/projects.html.twig');
});

$router->get('/contact', function () use ($twig) {
    return $twig->render('pages/contact.html.twig');
});
$router->dispatch();