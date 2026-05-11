<?php

namespace App\Controllers;

use App\Models\Page;

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
        // Récupérer les pages depuis la base de données
        $pages = Page::getAll();

        // Rendre la vue Twig en passant les pages
        return $this->twig->render('pages/index.html.twig', ["pages" => $pages]);
    }


    public function show($slug)
    {
        $page = Page::getBySlug($slug);

        if (!$page) {
            header("Location: /");
            exit;
        }

        $blocks = $page->getBlocks();
        return $this->twig->render('pages/show.html.twig', ["page" => $page, "blocks" => $blocks]);
    }

    public function add()
    {
        return $this->twig->render('pages/addOrEdit.html.twig');
    }

    public function edit($id)
    {
        $page = Page::getById($id);

        if (!$page) {
            header("Location: /");
            exit;
        }
        return $this->twig->render('pages/addOrEdit.html.twig', ["page" => $page]);
    }

    public function delete($id)
    {
        Page::delete($id);
        header("Location: /");
    }

    public function submit()
    {
        $name = $_POST["name"];
        Page::add($name);
        header("Location: /");
    }

    public function update($id)
    {
        $name = $_POST["name"];
        Page::edit($id, $name);
        header("Location: /");
    }
}
