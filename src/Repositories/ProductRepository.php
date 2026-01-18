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
            true
        );
    }
}