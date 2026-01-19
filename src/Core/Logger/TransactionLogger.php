<?php

declare(strict_types=1);

namespace SellNow\Core\Logger;

class TransactionLogger
{
    private string $logFile;

    /**
     * Create a new logger instance.
     */
    public function __construct()
    {
        $logDir = __DIR__ . '/../../storage/logs';

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $this->logFile = rtrim($logDir, '/') . '/transactions.log';
    }

    /**
     * Log a transaction
     *
     * @param string $provider
     * @param string|int|null $userId
     * @return void
     */
    public function log(string $provider, string|int|null $userId): void
    {
        $user = $userId ?? 'Guest';

        $line = sprintf(
            "[%s] Order processed via %s - User: %s\n",
            date('Y-m-d H:i:s'),
            $provider,
            $user
        );

        file_put_contents($this->logFile, $line, FILE_APPEND);
    }
}
