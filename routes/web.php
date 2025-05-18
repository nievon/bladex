<?php

use App\Middleware\CheckAuthMiddleware;

$router->get('/', ['ProductController', 'index']); // Главная: список товаров

$router->get('/product/{id}', ['ProductController', 'show']); // Просмотр одного товара

$router->post('/cart/add', ['ProductController', 'addToCart'], [new CheckAuthMiddleware()]); // Добавить товар в корзину

$router->get('/cart', ['ProductController', 'cart'], [new CheckAuthMiddleware()]); // Просмотр корзины

$router->get('/cart/remove/{id}', ['ProductController', 'removeFromCart'], [new CheckAuthMiddleware()]); // Удаление из корзины


$router->get('/login', ['AuthController', 'loginForm']);
$router->post('/login', ['AuthController', 'login']);
$router->get('/register', ['AuthController', 'registerForm']);
$router->post('/register', ['AuthController', 'register']);
$router->get('/logout', ['AuthController', 'logout']);