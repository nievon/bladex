<?php

require_once __DIR__ . '/../vendor/autoload.php';


use Core\Router;
use Core\Env;
use Core\View;
use Core\Database;
use Core\Middleware;

try {
// Загружаем переменные окружения
    Env::load(__DIR__ . '/../');

// Twig
    View::init(__DIR__ . '/../app/Views');

// Подключение к БД из .env
    Database::init([
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_NAME'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
    ]);

// Роутинг
    $router = new Router();

// Подключаем маршруты
    require_once __DIR__ . '/../routes/web.php';
    require_once __DIR__ . '/../core/Helpers.php';

// Обрабатываем запрос
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];

    $router->dispatch($uri, $method);
} catch (Throwable $e) {
    http_response_code(500);

    View::render('errors/500', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
    ]);
}
