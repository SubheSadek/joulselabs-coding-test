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

/**
 * Format string to slug
 */
function slugify(string $text, string $separator = '-') : string
{
    $text = preg_replace('/[^\pL\d]+/u', $separator, $text);
    
    $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
    
    $text = preg_replace('/[^-\w]+/', '', $text);
    
    $text = trim($text, $separator);
    $text = strtolower($text);
    
    $text = preg_replace('/-+/', $separator, $text);
    
    return $text;
}
