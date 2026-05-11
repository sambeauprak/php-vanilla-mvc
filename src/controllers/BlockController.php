<?php

namespace App\Controllers;

use App\Models\Block;

class BlockController
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
        // Récupérer les blocks depuis la base de données
        $blocks = Block::getAll();

        // Rendre la vue Twig en passant les blocks
        return $this->twig->render('blocks/index.html.twig', ["blocks" => $blocks]);
    }


    public function show($id)
    {
        $block = Block::getById($id);

        if (!$block) {
            header("Location: /");
            exit;
        }
        return $this->twig->render('blocks/components/' . $block->getSlug() . '.html.twig', ["block" => $block]);
    }

    public function add()
    {
        return $this->twig->render('blocks/addOrEdit.html.twig');
    }

    public function edit($id)
    {
        $block = Block::getById($id);

        if (!$block) {
            header("Location: /");
            exit;
        }
        return $this->twig->render('blocks/addOrEdit.html.twig', ["block" => $block]);
    }

    public function delete($id)
    {
        Block::delete($id);
        header("Location: /");
    }

    public function submit()
    {
        $name = $_POST["name"];
        $type_id = $_POST["type_id"];
        Block::add($name, $type_id = null);

        header("Location: /blocks");
    }

    public function update($id)
    {
        $name = $_POST["name"];
        $type_id = $_POST["type_id"];
        Block::edit($id, $name, $type_id = null);
        header("Location: /");
    }
}
