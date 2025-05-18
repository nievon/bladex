<?php

use Core\Migration;

return new class extends Migration {
    public function up(): void
    {
        // TODO: write SQL to create the table
        $this->pdo->exec(" CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
");
    }

    public function down(): void
    {
        // TODO: rollback the migration
        $this->pdo->exec("DROP TABLE IF EXISTS `create_table_orders`");
    }
};