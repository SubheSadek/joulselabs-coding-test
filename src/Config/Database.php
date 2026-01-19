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

        try {
            $connection = $_ENV['DB_CONNECTION'] ?? 'mysql';
            $host       = $_ENV['DB_HOST'] ?? '127.0.0.1';
            $port       = $_ENV['DB_PORT'] ?? null;
            $db_name    = $_ENV['DB_DATABASE'] ?? 'sellnow';
            $username   = $_ENV['DB_USERNAME'] ?? 'root';
            $password   = $_ENV['DB_PASSWORD'] ?? '';

            // Build DSN based on driver
            switch ($connection) {
                case 'pgsql':
                    $port = $port ?: 5432;
                    $dsn = "pgsql:host=$host;port=$port;dbname=$db_name";
                    break;

                case 'mysql':
                default:
                    $port = $port ?: 3306;
                    $dsn = "mysql:host=$host;port=$port;dbname=$db_name;charset=utf8mb4";
                    break;
            }

            $this->conn = new PDO($dsn, $username, $password);

            // Secure PDO settings
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (PDOException $e) {
            error_log($e->getMessage());
            die("Database connection failed. Please try again later." .  $e->getMessage());
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
