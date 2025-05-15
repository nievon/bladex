<?php

$router->get('/', ['HomeController', 'index']);
$router->get('/about', function () {
    echo "About page";
});
