<?php

use SellNow\Controllers\AuthController;
use SellNow\Controllers\HomeController;
use SellNow\Controllers\ProductController;

$router->get('/', [HomeController::class, 'index']);

//** Auth routes Start **/
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);

$router->get('/register', [AuthController::class, 'registerForm']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/dashboard', [AuthController::class, 'dashboard']);
$router->get('/logout', [AuthController::class, 'logout']);
//** Auth routes end **/

// ** Product routes Start **
$router->get('/products/add', [ProductController::class, 'create']);
$router->post('/products/add', [ProductController::class, 'store']);
// ** Product routes End **

