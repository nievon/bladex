<?php

namespace App\Controllers;

use App\Models\UsersModel;

class AuthController
{
    public function loginForm()
    {
        return view('login', ['title' => 'Login']);
    }

    public function registerForm()
    {
        return view('register', ['title' => 'Register']);
    }

    public function login()
    {
        session_start();
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = UsersModel::where('phone', $phone);
        $user = $user[1];

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user'] = [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
            ];
            header('Location: /');
            exit;
        }

        return view('login', ['error' => 'Invalid email or password']);
    }

    public function register()
    {
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$name || !$phone || !$password) {
            return view('register', ['error' => 'Please fill all fields']);
        }

        if (UsersModel::where('phone', $phone)) {
            return view('register', ['error' => 'Email already exists']);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        UsersModel::createUser($name, $phone, $hashedPassword);

        header('Location: /login');
        exit;
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}