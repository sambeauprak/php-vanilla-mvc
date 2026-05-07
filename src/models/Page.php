<?php

namespace App\Models;

use App\Controllers\DatabaseController;

use PDO;

class Page
{
    private $id;
    private $name;
    private $slug;
    private $created_at;
    private $updated_at;


    public function __construct($id = null, $name = '', $slug = '', $created_at = '', $updated_at = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

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
        return $this->slug;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public static function getAll()
    {
        $result = DatabaseController::getInstance()->query("SELECT * FROM page");
        $pages = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);

        return $pages;
    }

    public static function getById($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM page WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $page = $statement->fetch();


        return $page;
    }

    public static function getBySlug($slug)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "SELECT * FROM page WHERE slug = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$slug]);
        $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);
        $page = $statement->fetch();

        return $page;
    }

    private static function slugify($text)
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


    public static function add($name)
    {
        $slug = self::slugify($name);
        $pdo = DatabaseController::getInstance();
        $sql = "INSERT INTO page (name, slug) VALUES (?, ?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name, $slug]);
    }

    public static function edit($id, $name)
    {
        $slug = self::slugify($name);
        $pdo = DatabaseController::getInstance();
        $sql = "UPDATE page SET name = ?, slug = ? WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name, $slug, $id]);
    }

    public static function delete($id)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "DELETE FROM page WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
    }
}
