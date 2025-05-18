<?php

use Core\Migration;

return new class extends Migration {
    public function up(): void
    {
        // TODO: write SQL to create the table
        $this->pdo->exec(" CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
");
    }

    public function down(): void
    {
        // TODO: rollback the migration
        $this->pdo->exec("DROP TABLE IF EXISTS `create_table_products`");
    }
};