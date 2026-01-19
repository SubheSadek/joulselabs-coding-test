<?php

use SellNow\Controllers\AuthController;
use SellNow\Controllers\CartController;
use SellNow\Controllers\CheckoutController;
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

// ** Cart routes Start **
$router->get('/cart', [CartController::class, 'index']);
$router->post('/cart/add', [CartController::class, 'add']);
$router->get('/cart/clear', [CartController::class, 'clear']);
// ** Cart routes End **

// ** Checkout routes Start **
$router->get('/checkout', [CheckoutController::class, 'index']);
$router->post('/checkout/process', [CheckoutController::class, 'process']);
$router->get('/payment', [CheckoutController::class, 'payment']);
$router->post('/checkout/success', [CheckoutController::class, 'success']);
// ** Checkout routes End **

// ** Product routes Start **
$router->get('/products/add', [ProductController::class, 'create']);
$router->post('/products/add', [ProductController::class, 'store']);
$router->get('/{username}/shop', [ProductController::class, 'show']);
// ** Product routes End **

