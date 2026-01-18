<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class RequiredRule implements RuleInterface
{
    /**
     * Validate the given data against the specified rules.
     */
    public function validate(
        string $field,
        mixed $value,
        array $params = []
    ): ?string {
        $fieldName = formatSnakeCase($field);

        if ($this->isEmpty($value)) {
            return "{$fieldName} is required";
        }

        return null;
    }

    /**
     * Check if the value is empty.
     */
    protected function isEmpty(mixed $value): bool
    {
        if ($value === null) {
            return true;
        }

        if (is_array($value) && isset($value['error'])) {
            return $value['error'] !== UPLOAD_ERR_OK;
        }

        if (is_array($value)) {
            return empty($value);
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        return false;
    }
}
