<?php

namespace App\Models;

use App\Controllers\DatabaseController;

use PDO;

class Model
{
    protected static $tableName;
    public static function getAll()
    {
        $result = DatabaseController::getInstance()->query("SELECT * FROM " . static::$tableName);
        $pages = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::class);

        return $pages;
    }
}
