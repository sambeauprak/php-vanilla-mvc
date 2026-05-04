<?php

require_once __DIR__ . "/../models/Article.php";

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
            $articles = Article::getAll();
            return $this->twig->render('pages/index.html.twig', ["articles" => $articles]);
        };
    }

    public function add()
    {
        return function () {
            return $this->twig->render('pages/add.html.twig');
        };
    }

    public function submit()
    {
        return function () {
            $title = $_POST["titre"];
            Article::add($title);
            header("Location: /");
        };
    }
}
