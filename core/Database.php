<?php

namespace Core;

use RedBeanPHP\R;
use PDO;

class Database
{
    protected static PDO $pdo;

    public static function init(array $config)
    {
        R::setup(
            "mysql:host={$config['host']};dbname={$config['database']}",
            $config['username'],
            $config['password']
        );

        R::freeze(false);

        // Сохраняем PDO-инстанс
        self::$pdo = R::getDatabaseAdapter()
            ->getDatabase()
            ->getPDO();
    }

    public static function getInstance(): PDO
    {
        return self::$pdo;
    }
}
