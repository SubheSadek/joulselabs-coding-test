<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class IntegerRule implements RuleInterface
{
    public function validate(
        string $field,
        mixed $value,
        array $params = []
    ): ?string {
        
        $fieldName = formatSnakeCase($field);

        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            return "The {$fieldName} must be an integer.";
        }

        return null;
    }
}
