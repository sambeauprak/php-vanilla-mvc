<?php

namespace App\Controllers;

use App\Models\Block;
use App\Models\Page;
use App\Models\PageBlock;

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

    // =============================
    // Gestion des blocks dans une page
    // =============================

    public function manageBlocks($page_id)
    {
        $page = Page::getById($page_id);

        if (!$page) {
            header("Location: /");
            exit;
        }

        $allBlocks = Block::getAll();
        $attachedPageBlocks = PageBlock::getByPageId($page_id);
        $attachedBlockIds = array_map(function ($pb) {
            return $pb->getBlockId();
        }, $attachedPageBlocks);

        $attachedBlocks = [];
        foreach ($attachedPageBlocks as $pb) {
            $block = Block::getById($pb->getBlockId());
            if ($block) {
                $attachedBlocks[] = ["pb" => $pb, "block" => $block];
            }
        }

        $availableBlocks = array_filter($allBlocks, function ($b) use ($attachedBlockIds) {
            return !in_array($b->getId(), $attachedBlockIds);
        });

        return $this->twig->render('pages/manageBlocks.html.twig', [
            "page" => $page,
            "attachedBlocks" => $attachedBlocks,
            "availableBlocks" => $availableBlocks,
        ]);
    }

    public function addBlock($page_id)
    {
        $block_id = $_POST["block_id"];

        // Récupérer la position maximale actuelle pour ajouter à la fin
        $pageBlocks = PageBlock::getByPageId($page_id);
        $maxPosition = 0;
        foreach ($pageBlocks as $pb) {
            if ($pb->getPosition() > $maxPosition) {
                $maxPosition = $pb->getPosition();
            }
        }

        PageBlock::add($page_id, $block_id, $maxPosition + 1);
        header("Location: /pages/" . $page_id . "/blocks");
    }

    public function removeBlock($page_id, $pb_id)
    {
        PageBlock::delete($pb_id);
        header("Location: /pages/" . $page_id . "/blocks");
    }
}
