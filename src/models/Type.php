<?php

namespace App\Models;

use App\Controllers\DatabaseController;

use PDO;

/**
 * CREATE TABLE IF NOT EXISTS type (
 *   id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
 *   name VARCHAR(100),
 *   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
 * );
 */

class Type
{
    private $id;
    private $name;
    private $created_at;
    private $updated_at;

    public function __construct($id = null, $name = '', $created_at = '', $updated_at = '')
    {
        $this->id = $id;
        $this->name = $name;
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

    public function getName()
    {
        return $this->name;
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
     * Récupère tous les blocks associés à ce type
     */
    public function getBlocks()
    {
        return Block::getByTypeId($this->id);
    }

    // =============================
    // Méthodes statiques
    // =============================

    /**
     * Récupère tous les types
     */
    public static function getAll()
    {
        $result = DatabaseController::getInstance()->query("SELECT * FROM type");
        $types = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);

        return $types;
    }

    /**
     * Récupère un type par son id
     */
    public static function getById($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM type WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $type = $statement->fetch();

        return $type;
    }

    /**
     * Récupère un type par son nom
     */
    public static function getByName($name)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM type WHERE name = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $type = $statement->fetch();

        return $type;
    }

    /**
     * Ajoute un type
     */
    public static function add($name)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "INSERT INTO type (name) VALUES (?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name]);
    }

    /**
     * Modifie un type
     */
    public static function edit($id, $name)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "UPDATE type SET name = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name, $id]);
    }

    /**
     * Supprime un type
     */
    public static function delete($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "DELETE FROM type WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
    }
}
