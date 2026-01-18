<?php

use SellNow\Controllers\AuthController;
use SellNow\Controllers\HomeController;

$router->get('/', [HomeController::class, 'index']);

//** Auth routes **/
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);

$router->get('/register', [AuthController::class, 'registerForm']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/dashboard', [AuthController::class, 'dashboard']);
$router->get('/logout', [AuthController::class, 'logout']);
//** Auth routes end **/
