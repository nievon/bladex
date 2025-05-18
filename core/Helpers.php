<?php

use Core\View;

function view(string $template, array $data = [])
{
    View::render($template, $data);
}

function redirect(string $path = '/'): void
{
    header("Location: $path");
    exit;
}

