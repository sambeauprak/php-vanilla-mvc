<?php

class DatabaseController
{
    private static $instance;

    static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new PDO("sqlite:" . __DIR__ . "/../db/blog.db");
        }

        // create articles table
        $sql = "CREATE TABLE IF NOT EXISTS articles (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(30) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        self::$instance->exec($sql);


        return self::$instance;
    }
}
