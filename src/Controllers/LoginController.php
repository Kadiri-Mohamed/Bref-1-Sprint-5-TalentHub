<?php

namespace App\Controllers;

use App\Services\AuthService;

class LoginController
{
    public function login()
    {
        $auth = new AuthService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($auth->login($email, $password)) {
                $auth->redirectAfterLogin();
            }

            $error = "Invalid email or password";
        }

        require __DIR__ . '/../Views/auth/login.php';
    }
}
