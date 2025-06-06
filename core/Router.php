<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, callable|array $action, array $middlewares = [])
    {
        $this->routes['GET'][$uri] = ['action' => $action, 'middleware' => $middlewares];
    }

    public function post(string $uri, callable|array $action, array $middlewares = [])
    {
        $this->routes['POST'][$uri] = ['action' => $action, 'middleware' => $middlewares];
    }

    public function dispatch(string $uri, string $method)
    {
        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $routeUri => $route) {
            $pattern = preg_replace('#\{[\w]+\}#', '([\w-]+)', $routeUri);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Убираем полный матч
                $action = $route['action'];
                $middlewares = $route['middleware'];

                $final = function ($request) use ($action, $matches) {
                    if (is_array($action)) {
                        [$controller, $method] = $action;
                        $controller = "App\\Controllers\\$controller";
                        if (class_exists($controller)) {
                            $instance = new $controller();
                            if (method_exists($instance, $method)) {
                                return $instance->$method(...$matches);
                            }
                        }
                        http_response_code(500);
                        return view('home', ['title' => '500', 'text' => 'Controller or method not found.']);
                    }
                    return call_user_func_array($action, $matches);
                };

                return Middleware::run($middlewares, ['uri' => $uri, 'method' => $method], $final);
            }
        }

        http_response_code(404);
        return view('errors/400', ['title' => '404', 'text' => 'The page you are looking for doesnt exist or has been moved.']);
    }
}
