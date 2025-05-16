<?php

if ($argc < 2) {
    echo "❌ Specify the migration name, for example:\n";
    echo "   php create_migration.php create_users_table\n";
    exit(1);
}

$name = $argv[1];
$timestamp = date('Ymd_His');
$filename = "{$timestamp}_{$name}.php";


$baseDir = dirname(dirname(__DIR__));
$migrationsPath = $baseDir . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations';


if (!is_dir($migrationsPath)) {
    if (!mkdir($migrationsPath, 0777, true)) {
        echo "❌ Failed to create migrations directory: $migrationsPath\n";
        exit(1);
    }
}


$filepath = $migrationsPath . DIRECTORY_SEPARATOR . $filename;


if (file_exists($filepath)) {
    echo "⚠️ Migration already exists: $filepath\n";
    exit(1);
}


$template = <<<PHP
<?php

use Core\Migration;

return new class extends Migration {
    public function up(): void
    {
        // TODO: write SQL to create the table
        \$this->pdo->exec(" CREATE TABLE IF NOT EXISTS `{$name}` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `text` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `created_at` TIMESTAMP NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }

    public function down(): void
    {
        // TODO: rollback the migration
        \$this->pdo->exec("DROP TABLE IF EXISTS `{$name}`");
    }
};
PHP;


if (file_put_contents($filepath, $template) !== false) {
    echo "✅ Migration created successfully:\n";
    echo "   database/migrations/{$filename}\n";
} else {
    echo "❌ Failed to write migration file: $filepath\n";
}
