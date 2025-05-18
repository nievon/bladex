<?php

namespace App\Models;

use Core\Database;
use Core\Model;


class UsersModel extends Model
{
    // Add your model logic here
    protected static string $table = 'Users';

    public static function createUser($name, $phone, $password)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('INSERT INTO users (name, phone, password) VALUES (?, ?, ?)');
        return $stmt->execute([$name, $phone, $password]);
    }
}