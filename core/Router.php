<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, callable|array $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, callable|array $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch(string $uri, string $method)
    {
        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            http_response_code(404);
          return view('home', ['title' => '404', 'h1' => 'Страница не найдена'] );

        }

        if (is_array($action)) {
            [$controller, $method] = $action;
            $controller = "App\\Controllers\\$controller";
            if (class_exists($controller)) {
                $instance = new $controller();
                if (method_exists($instance, $method)) {
                    return call_user_func([$instance, $method]);
                }
            }

            http_response_code(500);
            echo "Controller or method not found.";
            return;
        }

        // Если коллбэк
        return call_user_func($action);
    }
}
