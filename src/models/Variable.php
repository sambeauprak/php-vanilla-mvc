<?php

namespace App\Models;

use App\Controllers\DatabaseController;

use PDO;

/**
 * CREATE TABLE IF NOT EXISTS variable (
 *   id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
 *   name VARCHAR(100),
 *   value TEXT,
 *   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 *   block_id INT,
 *   FOREIGN KEY (block_id) REFERENCES block (id)
 * );
 */

class Variable
{
    private $id;
    private $name;
    private $value;
    private $created_at;
    private $updated_at;
    private $block_id;

    public function __construct($id = null, $name = '', $value = '', $created_at = '', $updated_at = '', $block_id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->block_id = $block_id;
    }

    // =============================
    // Getters
    // =============================

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getBlockId()
    {
        return $this->block_id;
    }

    // =============================
    // Méthodes relationnelles
    // =============================

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
        $result = DatabaseController::getInstance()->query("SELECT * FROM variable");
        $variables = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);

        return $variables;
    }

    public static function getById($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM variable WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $variable = $statement->fetch();

        return $variable;
    }

    /**
     * Récupère toutes les variables associées à un block
     */
    public static function getByBlockId($block_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM variable WHERE block_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$block_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $variables = $statement->fetchAll();

        return $variables;
    }

    /**
     * Récupère une variable par son nom
     */
    public static function getByName($name)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM variable WHERE name = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $variable = $statement->fetch();

        return $variable;
    }

    public static function add($name, $value, $block_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "INSERT INTO variable (name, value, block_id) VALUES (?, ?, ?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name, $value, $block_id]);
    }

    public static function edit($id, $name, $value, $block_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "UPDATE variable SET name = ?, value = ?, block_id = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name, $value, $block_id, $id]);
    }

    public static function delete($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "DELETE FROM variable WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
    }

    /**
     * Supprime toutes les variables associées à un block
     */
    public static function deleteByBlockId($block_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "DELETE FROM variable WHERE block_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$block_id]);
    }
}
