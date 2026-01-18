<?php

namespace SellNow\Core\Validation\Rules;

class MinRule implements RuleInterface
{
    /**
     * Validate the given data against the specified rules.
     */
    public function validate(
        string $field,
        mixed $value,
        array $params,
    ): ?string {
        $min = (int) ($params[0] ?? 0);

        if ($value === null) {
            return null;
        }

        $field = formatSnakeCase($field);

        if (is_string($value) && strlen($value) < $min) {
            return "{$field} must be at least {$min} characters";
        }

        if (is_numeric($value) && $value < $min) {
            return "{$field} must be at least {$min}";
        }

        return null;
    }
}
