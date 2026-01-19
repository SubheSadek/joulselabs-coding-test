<?php

declare(strict_types=1);

namespace SellNow\Repositories;

use PDO;
use SellNow\Domain\User;

class UserRepository
{
    public function __construct(private PDO $db) {}

    /**
     * Find user by email
     * 
     * @param string $value
     * @return ?User
     */
    public function findByEmail(string $value): ?User
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = ? LIMIT 1"
        );

        $stmt->execute([$value]);

        $data = $stmt->fetch();
        return $data ? User::fromArray($data) : null;
    }

    /**
     * Find user by username
     * 
     * @param string $value
     * @return ?User
     */
    public function findByUsername(string $value): ?User
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE username = ? LIMIT 1"
        );

        $stmt->execute([$value]);

        $data = $stmt->fetch();
        return $data ? User::fromArray($data) : null;
    }

    /**
     * Find user by email or username
     * 
     * @param string $email
     * @param string $username
     * @return ?User
     */
    public function findByEmailOrUsername(string $email, string $username): ?User
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1"
        );

        $stmt->execute([$email, $username]);

        $data = $stmt->fetch();
        return $data ? User::fromArray($data) : null;
    }

    /**
     * Insert a new user and return the User entity
     */
    public function create(
        string $email,
        string $passwordHash,
        string $username,
        string $fullName
    ): User {
        $stmt = $this->db->prepare(
            "INSERT INTO users (email, password, username, full_name, created_at)
             VALUES (:email, :password, :username, :full_name, :created_at)"
        );

        $stmt->execute([
            ':email'    => $email,
            ':password' => $passwordHash,
            ':username' => $username,
            ':full_name' => $fullName,
            ':created_at' => date('Y-m-d H:i:s'),
        ]);

        $id = (int) $this->db->lastInsertId();

        return new User(
            $id,
            $email,
            $passwordHash,
            $username,
            $fullName
        );
    }
}
