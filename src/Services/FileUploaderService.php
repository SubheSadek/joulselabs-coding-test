<?php

declare(strict_types=1);

namespace SellNow\Services;

class FileUploaderService
{
    private string $uploadDir;

    public function __construct()
    {
        $this->uploadDir = __DIR__ . '/../../public/uploads/';
    }

    /**
     * Upload a file and return relative path or null
     */
    public function upload(
        ?array $file,
        string $prefix = ''
    ): ?string {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeName = $this->generateFileName($prefix, $extension);

        $destination = rtrim($this->uploadDir, '/') . '/' . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new \RuntimeException('File upload failed');
        }

        return 'uploads/' . $safeName;
    }

    /**
     * Generate a unique file name
     *
     * @param string $prefix
     * @param string $extension
     * @return string
     */
    private function generateFileName(string $prefix, string $extension): string
    {
        return trim($prefix . '_' . uniqid(), '_') . '.' . $extension;
    }
}
