<?php

namespace SellNow\Config;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null;
    private PDO $conn;

    private function __construct()
    {
        $isSqlite = true; // assessment mode

        try {
            if ($isSqlite) {
                $dbPath = __DIR__ . '/../../database/database.sqlite';
                $this->conn = new PDO("sqlite:" . $dbPath);
            } else {
                $host     = $_ENV['DB_HOST'] ?? '127.0.0.1';
                $db_name  = $_ENV['DB_NAME'] ?? 'sellnow';
                $username = $_ENV['DB_USER'] ?? 'root';
                $password = $_ENV['DB_PASS'] ?? '';

                $this->conn = new PDO(
                    "mysql:host=$host;dbname=$db_name;charset=utf8mb4",
                    $username,
                    $password
                );
            }

            // Secure PDO settings
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            die("Database connection failed. Please try again later.");
        }
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}
