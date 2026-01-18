<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class MimesRule implements RuleInterface
{
    public function validate(string $field, mixed $value, array $params = []): ?string
    {
        $field = formatSnakeCase($field);
        
        if (!is_array($value) || !isset($value['tmp_name'])) {
            return null; // file rule handles this
        }

        $extension = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $params, true)) {
            return "{$field} must be of type: " . implode(', ', $params);
        }

        return null;
    }
}
