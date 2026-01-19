<?php

declare(strict_types=1);

namespace SellNow\Repositories;

use PDO;
use SellNow\Domain\Product;

class ProductRepository
{
    public function __construct(private PDO $db) {}

    /**
     * Create a new product.
     */
    public function create(
        string $title,
        string $slug,
        float $price,
        ?string $description = null,
        ?string $imagePath = null,
        ?string $filePath = null
    ): Product {

        $userId = $_SESSION['user_id'];

        $stmt = $this->db->prepare(
            "INSERT INTO products (user_id, title, slug, description, price, image_path, file_path)
             VALUES (:user_id, :title, :slug, :description, :price, :image_path, :file_path)"
        );

        $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':slug' => $slug,
            ':description' => $description,
            ':price' => $price,
            ':image_path' => $imagePath,
            ':file_path' => $filePath
        ]);

        $id = (int) $this->db->lastInsertId();

        return new Product(
            $id,
            $userId,
            $title,
            $slug,
            $description,
            $price,
            $imagePath,
            $filePath,
            1
        );
    }

    /**
     * Get products by user id.
     */
    public function getProductsByUserId(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT id, user_id, title, slug, description, price, image_path, file_path, is_active
            FROM products
            WHERE user_id = ?
            ORDER BY id DESC"
        );

        $stmt->execute([$userId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => Product::fromArray($row), $rows);
    }

    /**
     * Get a single product by id.
     */
    public function getSingleProductById(int $id): ?Product
    {
        $stmt = $this->db->prepare(
            "SELECT id, user_id, title, slug, description, price, image_path, file_path, is_active
            FROM products
            WHERE id = ?"
        );

        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? Product::fromArray($row) : null;
    }

}