<?php

use SellNow\Core\Application;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

$app = new Application();
$app->run();
