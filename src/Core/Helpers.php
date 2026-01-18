<?php
declare(strict_types=1);

/**
 * Format snake_case string to camelCase
 */
function formatSnakeCase(string $string): string
{
    $string = str_replace('_', ' ', $string);
    return ucfirst(strtolower($string));
}
