<?php

class Article
{
    private $title;

    public function __construct($title = '')
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return "Titre: " . $this->title;
    }

    public static function getAll()
    {
        $result = DatabaseController::getInstance()->query("SELECT title FROM articles");
        $articles = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Article');

        return $articles;
    }

    public static function add($title)
    {
        $pdo = DatabaseController::getInstance();
        $sql = "INSERT INTO articles (title) VALUES (?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$title]);
    }
}
