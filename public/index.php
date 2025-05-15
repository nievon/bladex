<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use Core\View;

View::init(__DIR__ . '/../app/Views');

$router = new Router();

// Подключаем маршруты
require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../core/Helpers.php';

// Обрабатываем запрос
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);
