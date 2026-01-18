<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

use SellNow\Core\Validation\Rules\RuleInterface;

class RequiredRule implements RuleInterface
{
    /**
     * Validate the given data against the specified rules.
     */
    public function validate(string $field, mixed $value, array $params = []): ?string
    {
        $field = formatSnakeCase($field);
        
        if ($value === null || trim((string)$value) === '') {
            return "{$field} is required";
        }

        return null;
    }
}
