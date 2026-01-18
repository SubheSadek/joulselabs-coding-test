<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class StringRule implements RuleInterface
{
    /**
     * Validate the given data against the specified rules.
     */
    public function validate(string $field, mixed $value, array $params = []): ?string
    {
        $field = formatSnakeCase($field);
        
        if (!is_string($value)) {
            return "{$field} must be a string";
        }
        return null;
    }
}
