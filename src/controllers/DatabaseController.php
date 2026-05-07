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
            } else {
                self::$instance = new PDO(
                    $_ENV['DATABASE_ENGINE'] . ":host=" . $_ENV['DATABASE_HOST'] . ";dbname=" . $_ENV['DATABASE_NAME'],
                    $_ENV['DATABASE_USER'],
                    $_ENV['DATABASE_PASSWORD']
                );
            }
        }

        return self::$instance;
    }
}
