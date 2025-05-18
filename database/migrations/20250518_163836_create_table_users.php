<?php

use Core\Migration;

return new class extends Migration {
    public function up(): void
    {
        // TODO: write SQL to create the table
        $this->pdo->exec(" CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    phone VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
");
    }

    public function down(): void
    {
        // TODO: rollback the migration
        $this->pdo->exec("DROP TABLE IF EXISTS `create_table_users`");
    }
};