<?php
require_once '../vendor/autoload.php'; // Import autoload

$loader = new \Twig\Loader\FilesystemLoader('../src/views');
$twig = new \Twig\Environment($loader);


$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Sert les fichiers statiques s'ils existent (css, js, images...)
if ($requestUri !== '/' && file_exists(__DIR__ . $requestUri)) {
    return false;
}

// Redirige les URLs avec slash final (équivalent du R=301)
if ($requestUri !== '/' && str_ends_with($requestUri, '/')) {
    $trimmed = rtrim($requestUri, '/');
    header("Location: $trimmed", true, 301);
    exit;
}

require_once __DIR__ . "/../src/routes.php";