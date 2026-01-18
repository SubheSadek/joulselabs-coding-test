<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class ConfirmedRule implements RuleInterface
{
    /**
     * Validate the given data against the specified rules.
     */
    public function validate(string $field, mixed $value, array $params = [], array $data = []): ?string
    {
        $confirmationField = $field . '_confirmation';
        $field = formatSnakeCase($field);

        if (!array_key_exists($confirmationField, $data)) {
            return "{$field} confirmation field is missing";
        }

        if ($value !== $data[$confirmationField]) {
            return "{$field} confirmation does not match";
        }

        return null;
    }
}
