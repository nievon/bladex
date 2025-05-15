<?php

use Core\Migration;

return new class extends Migration {
    public function up(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS `posts` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `title` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `text` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `created_at` TIMESTAMP NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        $this->pdo->exec("
            INSERT INTO `posts` (`title`, `text`, `created_at`) VALUES
            ('Плюшки нашего фреймворка', 'Фреймворк имеет минималистичную архитектуру, простую маршрутизацию и поддержку шаблонов через Twig. Отлично подойдёт для pet-проектов и обучения.', '2025-05-15 11:55:01'),
            ('Особенности роутинга', 'Маршруты легко добавляются через конфиг, поддерживаются GET и POST методы, можно назначать контроллеры и методы по имени маршрута.', '2025-05-15 11:55:01'),
            ('Работа с ORM', 'Встроен RedBeanPHP с удобной обёрткой. Можно использовать Post::all(), Post::find(id), Post::create([...]) и другие методы без лишнего кода.', '2025-05-15 11:55:01');
        ");
    }

    public function down(): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS `posts`;");
    }
};