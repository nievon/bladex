<?php

namespace Core;

use Dotenv\Dotenv;

class Env
{
    public static function load(string $basePath)
    {
        $dotenv = Dotenv::createImmutable($basePath);
        $dotenv->load();
    }
}
