<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Utils\Validator;

class RegisterController
{
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->roleRepository = new RoleRepository();
    }

    public function index(): void
    {
        require __DIR__ . '/../Views/auth/register.php';
    }

    public function register(): void
    {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $roleName = $_POST['role'] ?? '';

        if (!Validator::required($name) || !Validator::alpha($name)) {
            $error = 'Invalid name.';
        } elseif (!Validator::email($email)) {
            $error = 'Invalid email address.';
        } elseif (!Validator::minLength($password, 6)) {
            $error = 'Password must be at least 6 characters.';
        } elseif (!Validator::inArray($roleName, ['candidate', 'recruiter'])) {
            $error = 'Invalid role selected.';
        } elseif ($this->userRepository->findByEmail($email)) {
            $error = 'Email already exists.';
        }

        if (isset($error)) {
            require __DIR__ . '/../Views/auth/register.php';
            return;
        }

        $role = $this->roleRepository->findByName($roleName);

        if (!$role) {
            $error = 'Role not found.';
            require __DIR__ . '/../Views/auth/register.php';
            return;
        }

        $this->userRepository->create([
            'name'     => $name,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role_id'  => $role->getId()
        ]);

        header('Location: /login');
        exit;
    }
}
