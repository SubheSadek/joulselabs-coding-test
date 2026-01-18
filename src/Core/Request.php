<?php

declare(strict_types=1);

namespace SellNow\Core;

class Request
{
    /**
     * @return static
     */
    public static function capture(): self
    {
        return new self();
    }

    /**
     * @return string
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function input(string $key, $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    /**
     * Check if a valid file was uploaded
     *
     * @param string $key
     * @return bool
     */
    public function hasFile(string $key): bool
    {
        if (!isset($_FILES[$key])) {
            return false;
        }

        if (is_array($_FILES[$key]['error'])) {
            return in_array(UPLOAD_ERR_OK, $_FILES[$key]['error'], true);
        }

        return $_FILES[$key]['error'] === UPLOAD_ERR_OK;
    }

    /**
     * Get uploaded file information
     *
     * @param string $key
     * @return array|null
     */
    public function file(string $key): ?array
    {
        if (!$this->hasFile($key)) {
            return null;
        }

        return $_FILES[$key];
    }
}
