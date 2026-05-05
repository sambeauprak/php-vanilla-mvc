<?php

namespace App\Controllers;

use PDO;

class DatabaseController
{
    private static $instance;

    static function getInstance()
    {
        if (!self::$instance) {
            if ($_ENV['DATABASE_ENGINE'] === 'sqlite') {
                self::$instance = new PDO("sqlite:" . __DIR__ . "/../db/" . $_ENV['DATABASE_FILE']);
            }
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
