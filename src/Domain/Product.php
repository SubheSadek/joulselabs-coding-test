<?php

declare(strict_types=1);

namespace SellNow\Domain;

class Product
{
    public function __construct(
        public int $id,
        public int $user_id,
        public string $title,
        public string $slug,
        public ?string $description,
        public float $price,
        public ?string $image_path,
        public ?string $file_path,
        public int | bool $is_active
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['user_id'],
            $data['title'],
            $data['slug'],
            $data['description'],
            $data['price'],
            $data['image_path'],
            $data['file_path'],
            $data['is_active']
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function userId(): int
    {
        return $this->user_id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function imagePath(): ?string
    {
        return $this->image_path;
    }

    public function filePath(): ?string
    {
        return $this->file_path;
    }

    public function isActive(): bool
    {
        return $this->is_active === 1;
    }
    
}