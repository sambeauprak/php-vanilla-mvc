<?php

namespace App\Models;

use App\Controllers\DatabaseController;

use PDO;

/**
 * CREATE TABLE IF NOT EXISTS block (
 *   id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
 *   name VARCHAR(100),
 *   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 *   type_id INT,
 *   FOREIGN KEY (type_id) REFERENCES type (id)
 * );
 */

class Block
{
    private $id;
    private $name;
    private $created_at;
    private $updated_at;
    private $type_id;

    public function __construct($id = null, $name = '', $created_at = '', $updated_at = '', $type_id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->type_id = $type_id;
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

    public function getSlug()
    {
        return self::slugify($this->name);
    }


    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getTypeId()
    {
        return $this->type_id;
    }

    // =============================
    // Méthodes relationnelles
    // =============================

    /**
     * Récupère le type associé au block
     */
    public function getType()
    {
        return Type::getById($this->type_id);
    }

    public function getVariables()
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM variable WHERE block_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$this->id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Variable::class);
        $variables = $statement->fetchAll();

        return $variables;
    }

    public function addVariable($name, $value)
    {
        Variable::add($this->id, $name, $value);
    }

    // =============================
    // Méthodes statiques
    // =============================

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicated - symbols
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Récupère tous les blocks
     */
    public static function getAll()
    {
        $result = DatabaseController::getInstance()->query("SELECT * FROM block");
        $blocks = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);

        return $blocks;
    }

    /**
     * Récupère un block par son id
     */
    public static function getById($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM block WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $block = $statement->fetch();

        return $block;
    }

    /**
     * Récupère tous les blocks associés à un type
     */
    public static function getByTypeId($type_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM block WHERE type_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$type_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $blocks = $statement->fetchAll();

        return $blocks;
    }

    /**
     * Ajoute un block
     */
    public static function add($name, $type_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "INSERT INTO block (name, type_id) VALUES (?, ?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name, $type_id]);
    }

    /**
     * Modifie un block
     */
    public static function edit($id, $name, $type_id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "UPDATE block SET name = ?, type_id = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name, $type_id, $id]);
    }

    /**
     * Supprime un block
     */
    public static function delete($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "DELETE FROM block WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
    }
}
