<?php

$router->get('/', ['ProductController', 'index']); // Главная: список товаров

$router->get('/product/{id}', ['ProductController', 'show']); // Просмотр одного товара

$router->post('/cart/add', ['ProductController', 'addToCart']); // Добавить товар в корзину

$router->get('/cart', ['ProductController', 'cart']); // Просмотр корзины

$router->post('/cart/remove/{id}', ['ProductController', 'removeFromCart']); // Удаление из корзины