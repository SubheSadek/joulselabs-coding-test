<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

interface RuleInterface
{
    public function validate(
        string $field,
        mixed $value,
        array $params
    ): ?string;
}