<?php

declare(strict_types=1);

namespace SellNow\Core\Security;

class Csrf
{
    private const SESSION_KEY = '_csrf_token';

    /**
     * Generate or return existing CSRF token
     */
    public static function token(): string
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * Validate a submitted CSRF token
     */
    public static function validate(?string $token): bool
    {
        if (!$token || empty($_SESSION[self::SESSION_KEY])) {
            return false;
        }

        return hash_equals($_SESSION[self::SESSION_KEY], $token);
    }

    /**
     * Regenerate token (optional, after login/logout/payment)
     */
    public static function regenerate(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
    }
}
