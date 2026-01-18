<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class EmailRule implements RuleInterface
{
    /**
     * Validate the given data against the specified rules.
     */
    public function validate(string $field, mixed $value, array $params = []): ?string
    {
        $field = formatSnakeCase($field);
        
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "{$field} must be a valid email";
        }
        return null;
    }
}
