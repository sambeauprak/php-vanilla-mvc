<?php

class DatabaseController
{
    private static $instance;

    static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new PDO("sqlite:" . __DIR__ . "/../db/chinook.db");
        }

        return self::$instance;
    }
}