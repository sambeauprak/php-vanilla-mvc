<?php

class PageController
{

    private \Twig\Environment $twig; // Typer une variable (pas obligatoire en PHP)

    function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../src/views');
        $this->twig = new \Twig\Environment($loader);
    }

    function index()
    {
        return function () {
            return $this->twig->render('pages/index.html.twig');
        };
    }

    function bio()
    {
        return function () {
            return $this->twig->render('pages/bio.html.twig');
        };
    }

    function projects()
    {
        return function () {
            return $this->twig->render('pages/projects.html.twig');
        };
    }

    function contact()
    {
        return function () {
            return $this->twig->render('pages/contact.html.twig');
        };
    }

    function lists()
    {
        return function () {
            $pdo = DatabaseController::getInstance();
            $result = $pdo->query("SELECT * FROM employees");

            $users = $result->fetchAll();
            return $this->twig->render('pages/lists.html.twig', ["users" => $users]);
        };
    }
}