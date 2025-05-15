<?php

namespace Core;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    protected static Environment $twig;

    public static function init(string $path)
    {
        $loader = new FilesystemLoader($path);
        self::$twig = new Environment($loader, [
            'cache' => false,
            'auto_reload' => true,
        ]);
    }

    public static function render(string $template, array $data = [])
    {
        echo self::$twig->render($template . '.twig', $data);
    }
}
