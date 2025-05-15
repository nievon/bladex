<?php

namespace App\Controllers;

use App\Models\Post;

class HomeController
{
    public function index()
    {
        return view('home', ['title' => 'Главная страница', 'text' => 'Добро пожаловать в Bladex!']);
    }

    public function posts()
    {
        $posts = Post::all();
        return view('home', ['title' => 'ORM', 'text' => 'RedBeanPHP в Bladex!', 'posts' => $posts]);
    }
}
