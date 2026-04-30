<?php

class PageController
{

    private \Twig\Environment $twig; // Typer une variable (pas obligatoire en PHP)

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../src/views');
        $this->twig = new \Twig\Environment($loader);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }

    public function index()
    {
        return function () {
            return $this->twig->render('pages/index.html.twig');
        };
    }

    public function bio()
    {
        return function () {
            return $this->twig->render('pages/bio.html.twig');
        };
    }

    public function projects()
    {
        return function () {
            return $this->twig->render('pages/projects.html.twig');
        };
    }

    public function contact()
    {
        return function () {
            return $this->twig->render('pages/contact.html.twig');
        };
    }

    public function lists()
    {
        return function () {
            $pdo = $this->getPdo();
            $result = $pdo->query("SELECT * FROM employees");

            $users = $result->fetchAll();
            return $this->twig->render('pages/lists.html.twig', ["users" => $users]);
        };
    }

    private function getPdo()
    {
        return DatabaseController::getInstance();
    }
}