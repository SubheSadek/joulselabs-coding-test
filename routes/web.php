<?php

use SellNow\Controllers\HomeController;

$router->get('/', [HomeController::class, 'index']);
