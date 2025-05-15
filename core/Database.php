<?php

namespace Core;

use RedBeanPHP\R;


class Database
{
    public static function init(array $config)
    {
        R::setup(
            "mysql:host={$config['host']};dbname={$config['database']}",
            $config['username'],
            $config['password']
        );

        // Отключаем заморозку модели (для dev)
        R::freeze(false);
    }
}
