<?php

namespace App\Models;

use App\Controllers\DatabaseController;

use PDO;

/**
 * CREATE TABLE IF NOT EXISTS page_block (
 *   id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
 *   page_id INT,
 *   block_id INT,
 *   position INT,
 *   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 *   FOREIGN KEY (page_id) REFERENCES page (id),
 *   FOREIGN KEY (block_id) REFERENCES block (id)
 * );
 */

class PageBlock
{
    private $id;
    private $page_id;
    private $block_id;
    private $position;
    private $created_at;
    private $updated_at;

    public function __construct($id = null, $page_id = null, $block_id = null, $position = 0, $created_at = '', $updated_at = '')
    {
        $this->id = $id;
        $this->page_id = $page_id;
        $this->block_id = $block_id;
        $this->position = $position;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // =============================
    // Getters
    // =============================

    public function getId()
    {
        return $this->id;
    }

    public function getPageId()
    {
        return $this->page_id;
    }

    public function getBlockId()
    {
        return $this->block_id;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    // =============================
    // Méthodes relationnelles
    // =============================

    /**
     * Récupère la page associée
     */
    public function getPage()
    {
        return Page::getById($this->page_id);
    }

    /**
     * Récupère le block associé
     */
    public function getBlock()
    {
        return Block::getById($this->block_id);
    }

    // =============================
    // Méthodes statiques
    // =============================

    public static function getAll()
    {
        $result = DatabaseController::getInstance()->query("SELECT * FROM page_block ORDER BY position ASC");
        $pageBlocks = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);

        return $pageBlocks;
    }

    public static function getById($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM page_block WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $pageBlock = $statement->fetch();

        return $pageBlock;
    }

    /**
     * Récupère tous les blocks associés à une page, triés par position
     */
    public static function getByPageId($page_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM page_block WHERE page_id = ? ORDER BY position ASC";
        $statement = $pdo->prepare($sql);
        $statement->execute([$page_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $pageBlocks = $statement->fetchAll();

        return $pageBlocks;
    }

    /**
     * Récupère toutes les pages associées à un block
     */
    public static function getByBlockId($block_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM page_block WHERE block_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$block_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $pageBlocks = $statement->fetchAll();

        return $pageBlocks;
    }

    public static function add($page_id, $block_id, $position = 0)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "INSERT INTO page_block (page_id, block_id, position) VALUES (?, ?, ?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$page_id, $block_id, $position]);
    }

    public static function edit($id, $page_id, $block_id, $position)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "UPDATE page_block SET page_id = ?, block_id = ?, position = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$page_id, $block_id, $position, $id]);
    }

    public static function delete($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "DELETE FROM page_block WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
    }

    /**
     * Supprime tous les blocks associés à une page
     */
    public static function deleteByPageId($page_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "DELETE FROM page_block WHERE page_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$page_id]);
    }

    /**
     * Supprime toutes les pages associées à un block
     */
    public static function deleteByBlockId($block_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "DELETE FROM page_block WHERE block_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$block_id]);
    }
}
