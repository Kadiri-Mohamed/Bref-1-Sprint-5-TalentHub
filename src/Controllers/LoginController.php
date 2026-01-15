<?php

namespace App\Controllers;

use App\Services\AuthService;

class LoginController
{

    public function index($error = '')
    {
        require __DIR__ . '/../Views/auth/login.php';
    }
    public function login()
    {
        $auth = new AuthService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($auth->login($email, $password)) {
                $auth->redirectAfterLogin();
            } else {
                $error = "Invalid email or password";
                $this->index($error);
            }


        }
    }
}
