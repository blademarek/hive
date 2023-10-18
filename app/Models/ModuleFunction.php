<?php

namespace Hive5\Models;

use Hive5\Database;

class ModuleFunction
{
    public static function findByName(string $name): object|false|null
    {
        $query = 'SELECT * from module_function where name = ?';
        return Database::getInstance()->query($query, [$name]);
    }
}