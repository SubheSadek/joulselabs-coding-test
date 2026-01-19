<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

use SellNow\Config\Database;

$pdo = Database::getInstance()->getConnection();

// drop all tables
$pdo->exec("DROP TABLE IF EXISTS users CASCADE");
$pdo->exec("DROP TABLE IF EXISTS products CASCADE");
$pdo->exec("DROP TABLE IF EXISTS carts CASCADE");
$pdo->exec("DROP TABLE IF EXISTS orders CASCADE");
$pdo->exec("DROP TABLE IF EXISTS payment_providers CASCADE");
$pdo->exec("DROP TABLE IF EXISTS migrations CASCADE");