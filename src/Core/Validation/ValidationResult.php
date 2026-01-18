<?php

declare(strict_types=1);

namespace SellNow\Core\Validation;

class ValidationResult
{
    public function __construct(private array $errors) {}

    /**
     * Check if validation failed.
     */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get all validation errors.
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Get the first validation error for a field.
     */
    public function first(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }
}
