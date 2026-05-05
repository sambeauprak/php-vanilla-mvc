<?php

namespace App\Controllers;

use App\Models\Article;

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
        // Récupérer les articles depuis la base de données
        $articles = Article::getAll();

        // Rendre la vue Twig en passant les articles
        return $this->twig->render('pages/index.html.twig', ["articles" => $articles]);
    }

















    public function add()
    {
        return $this->twig->render('pages/add.html.twig');
    }

    public function submit()
    {
        $title = $_POST["titre"];
        Article::add($title);
        header("Location: /");
    }
}
