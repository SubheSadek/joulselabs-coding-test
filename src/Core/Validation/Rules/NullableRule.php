<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class NullableRule implements RuleInterface
{
    /**
     * Validate the given data against the specified rules.
     */
    public function validate(string $field, mixed $value, array $params = []): ?string
    {
        return null;
    }
}
