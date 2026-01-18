<?php

declare(strict_types=1);

namespace SellNow\Core\Validation\Rules;

class FileRule implements RuleInterface
{
    public function validate(string $field, mixed $value, array $params = []): ?string
    {
        $field = formatSnakeCase($field);
        
        if (!is_array($value) || !isset($value['tmp_name'])) {
            return "{$field} must be a file";
        }

        if (($value['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return "{$field} upload failed";
        }

        return null;
    }
}
