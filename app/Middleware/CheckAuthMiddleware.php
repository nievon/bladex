<?php

namespace App\Middleware;

class CheckAuthMiddleware
{
    public function __invoke($request, $next)
    {

        // Пример простой авторизации через сессию
        session_start();

        if (empty($_SESSION['user'])) {
            // Если пользователь не авторизован — редирект на /login
            header('Location: /login');
            exit;
        }

        return $next($request);

    }
}