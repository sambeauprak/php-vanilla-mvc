<?php

namespace App\Controllers;

use App\Models\Block;
use App\Models\Variable;

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

    // =============================
    // Gestion des variables (variants)
    // =============================

    public function variables($block_id)
    {
        $block = Block::getById($block_id);

        if (!$block) {
            header("Location: /blocks");
            exit;
        }

        $variables = Variable::getByBlockId($block_id);
        return $this->twig->render('variables/index.html.twig', ["block" => $block, "variables" => $variables]);
    }

    public function addVariable($block_id)
    {
        $block = Block::getById($block_id);

        if (!$block) {
            header("Location: /blocks");
            exit;
        }

        return $this->twig->render('variables/addOrEdit.html.twig', ["block" => $block]);
    }

    public function editVariable($block_id, $variable_id)
    {
        $block = Block::getById($block_id);
        $variable = Variable::getById($variable_id);

        if (!$block || !$variable) {
            header("Location: /blocks");
            exit;
        }

        return $this->twig->render('variables/addOrEdit.html.twig', ["block" => $block, "variable" => $variable]);
    }

    public function submitVariable($block_id)
    {
        $name = $_POST["name"];
        $value = $_POST["value"];
        Variable::add($name, $value, $block_id);

        header("Location: /blocks/" . $block_id . "/variables");
    }

    public function updateVariable($block_id, $variable_id)
    {
        $name = $_POST["name"];
        $value = $_POST["value"];
        Variable::edit($variable_id, $name, $value, $block_id);

        header("Location: /blocks/" . $block_id . "/variables");
    }

    public function deleteVariable($block_id, $variable_id)
    {
        Variable::delete($variable_id);
        header("Location: /blocks/" . $block_id . "/variables");
    }
}
