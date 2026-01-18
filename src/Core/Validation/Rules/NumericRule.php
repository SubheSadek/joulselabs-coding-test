<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class NumericRule implements RuleInterface
{
    /**
     * Validate that the value is numeric.
     *
     * @param string $field
     * @param mixed $value
     * @param array $params
     * @return ?string
     */
    public function validate(
        string $field,
        mixed $value,
        array $params
    ): ?string {
        if (!is_numeric($value)) {
            return "The {$field} must be a number.";
        }

        return null;
    }
}
