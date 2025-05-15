<?php

use Core\View;

function view(string $template, array $data = [])
{
    View::render($template, $data);
}
