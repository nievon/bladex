<?php

require __DIR__ . '/../vendor/autoload.php'; // подняться на уровень выше

use Dotenv\Dotenv;
use Core\Database;
use Core\Env;

// Загружаем переменные окружения
Env::load(__DIR__ . '/../');

// Инициализируем подключение к БД
Database::init([
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
]);

// Путь к миграциям
$migrationsPath = dirname(__DIR__) . '/database/migrations';
$files = glob($migrationsPath . '/*.php');

if (empty($files)) {
    echo "ℹ️ No migration files found in /database/migrations\n";
    exit(0);
}

// Выполняем каждую миграцию
foreach ($files as $file) {
    echo "🚀 Running migration: " . basename($file) . "\n";
    $migration = require $file;

    if (is_object($migration) && method_exists($migration, 'up')) {
        $migration->up();
    } else {
        echo "⚠️ Skipped invalid migration file: " . basename($file) . "\n";
    }
}

echo "✅ All migrations applied successfully.\n";
