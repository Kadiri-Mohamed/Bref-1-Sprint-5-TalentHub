<?php
// src/Core/Middleware/RoleMiddleware.php

namespace App\Core\Middleware;

use App\Core\Session;

class RoleMiddleware implements MiddlewareInterface
{
    private string $requiredRole;

    public function __construct(string $role)
    {
        Session::init();
        $this->requiredRole = $role;
    }

    public function handle(): void
    {
        if (Session::get('role_name') !== $this->requiredRole) {
            http_response_code(403);
            echo "Accès interdit : Ce rôle n'a pas les permissions nécessaires.";
            echo "\n";
            echo  Session::get('role_name')."!=" . $this->requiredRole;
            exit;
        }
    }
}