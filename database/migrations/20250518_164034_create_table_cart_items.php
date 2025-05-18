<?php

use Core\Migration;

return new class extends Migration {
    public function up(): void
    {
        // TODO: write SQL to create the table
        $this->pdo->exec(" CREATE TABLE cartitems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
");
    }

    public function down(): void
    {
        // TODO: rollback the migration
        $this->pdo->exec("DROP TABLE IF EXISTS `create_table_cart_items`");
    }
};