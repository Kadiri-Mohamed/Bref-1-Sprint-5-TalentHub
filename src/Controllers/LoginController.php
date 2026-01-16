<?php

namespace App\Controllers;

use App\Services\AuthService;
use App\Core\Twig;

class LoginController
{
    public function index($error = '')
    {
        Twig::display('auth/login.twig', [
            'error' => $error,
            'title' => 'Connexion'
        ]);
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
                $error = "Email ou mot de passe incorrect";
                Twig::display('auth/login.twig', [
                    'error' => $error,
                    'title' => 'Connexion'
                ]);
            }
        }
    }
}