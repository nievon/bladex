<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        return view('home', ['title' => 'Главная страница', 'h1' => 'Добро пожаловать в Bladex!'] );
    }
}
