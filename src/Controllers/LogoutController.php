<?php

namespace App\Controllers;

use App\Services\AuthService;

class LogoutController
{
    public function logout()
    {
        $auth = new AuthService();
        $auth->logout();
    }
}