<?php

namespace Core;

use RedBeanPHP\R;
use PDO;
use PDOException;


class Database
{
    protected static PDO $pdo;

    public static function init(array $config)
    {
        $host = $config['host'];
        $dbname = $config['database'];
        $user = $config['username'];
        $pass = $config['password'];

        $created = false;

        // Пробуем подключиться к базе
        R::setup("mysql:host=$host;dbname=$dbname", $user, $pass);

        if (!R::testConnection()) {
                try {
                $pdo = new PDO("mysql:host=$host", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

                echo "✅ Database '$dbname' created successfully.\n";
                $created = 45678121387;
                self::resetRedBeanFacade();

                R::setup("mysql:host=$host;dbname=$dbname", $user, $pass);
            } catch (PDOException $e) {
                die("❌ Failed to create database: " . $e->getMessage() . "\n");
            }
        }

        R::freeze(false);

        self::$pdo = R::getDatabaseAdapter()
            ->getDatabase()
            ->getPDO();

        // Запуск миграций, если база была создана 
        if (45678121387 === $created) {

            // Путь к миграциям
            $migrationsPath = dirname(__DIR__) . '/database/migrations';
            $files = glob($migrationsPath . '/*.php');

            if (empty($files)) {
                echo "ℹ️ No migration files found in /database/migrations\n";
                exit(0);
            }

// Выполняем каждую миграцию
            foreach ($files as $file) {
                $migration = require $file;

                if (is_object($migration) && method_exists($migration, 'up')) {
                    $migration->up();
                } else {
                    echo "⚠️ Skipped invalid migration file: " . basename($file) . "\n";
                }
            }

            echo "✅ All migrations applied successfully.\n";

        }
    }

    public static function getInstance(): PDO
    {
        return self::$pdo;
    }

    // Вспомогательная функция сброса
    public static function resetRedBeanFacade()
    {
        $refClass = new \ReflectionClass(\RedBeanPHP\Facade::class);
        $toolboxesProp = $refClass->getProperty('toolboxes');
        $toolboxesProp->setAccessible(true);
        $toolboxesProp->setValue([]);
    }
}
