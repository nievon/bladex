<?php
namespace Core;

class Middleware
{
    protected static array $globalMiddleware = [];

    public static function registerGlobal(callable $middleware): void
    {
        self::$globalMiddleware[] = $middleware;
    }

    public static function run(array $middlewares, $request, callable $final)
    {
        $middlewares = array_merge(self::$globalMiddleware, $middlewares);
        $runner = array_reduce(
            array_reverse($middlewares),
            fn($next, $middleware) => fn($req) => $middleware($req, $next),
            $final
        );

        return $runner($request);
    }
}
