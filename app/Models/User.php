<?php

namespace Hive5\Models;

use Hive5\Database;

class User
{
    public static function findByName(string $userName): object|false|null
    {
        $query = 'SELECT * from user where username = ?';
        return Database::getInstance()->query($query, [$userName]);
    }

    public static function hasAccess(object $user, object $function): bool
    {
        $query = "SELECT COUNT(*) as count
                    FROM access
                    WHERE (user_id = {$user->id} OR group_id = {$user->group_id})
                    AND (module_function_id = {$function->id} OR module_id = {$function->module_id})
                  ";

        return Database::getInstance()->query($query)->count > 0;
    }
}