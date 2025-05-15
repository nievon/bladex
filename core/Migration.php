<?php

namespace Core;

use PDO;

abstract class Migration {
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance(); // берём PDO из подключения
    }

    abstract public function up(): void;
    abstract public function down(): void;
}
