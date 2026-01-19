<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

use SellNow\Config\Database;

$pdo = Database::getInstance()->getConnection();

// Ensure migrations table exists
$pdo->exec("
    CREATE TABLE IF NOT EXISTS migrations (
        id SERIAL PRIMARY KEY,
        migration VARCHAR(255) NOT NULL UNIQUE,
        executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// Get already executed migrations
$executed = $pdo->query("SELECT migration FROM migrations")
                ->fetchAll(PDO::FETCH_COLUMN);

$files = glob(__DIR__ . '/migrations/*.sql');
sort($files);

echo "Running migrations...\n";

foreach ($files as $file) {
    $name = basename($file);

    if (in_array($name, $executed)) {
        echo "Skipping: $name (already executed)\n";
        continue;
    }

    echo "Running: $name\n";

    $sql = file_get_contents($file);
    $pdo->exec($sql);

    $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
    $stmt->execute([$name]);
}

echo "✅ All migrations are up to date.\n";
