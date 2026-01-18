<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class MaxRule implements RuleInterface
{
    /**
     * Validate the given data against the specified rules.
     */
    public function validate(string $field, mixed $value, array $params = []): ?string
    {
        $field = formatSnakeCase($field);
        
        $max = (int) ($params[0] ?? 0);

        if (is_string($value) && strlen($value) > $max) {
            return "{$field} must not exceed {$max} characters";
        }

        if (is_array($value) && isset($value['size'])) {
            if (($value['size'] / 1024) > $max) {
                return "{$field} must not exceed {$max} KB";
            }
        }

        return null;
    }
}
