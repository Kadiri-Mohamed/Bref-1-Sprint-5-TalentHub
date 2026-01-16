<?php

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Utils\Validator;
use App\Core\Twig;

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
        Twig::display('auth/register.twig', [
            'title' => 'Inscription',
            'post' => $_POST ?? []
        ]);
    }

    public function register(): void
    {
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $roleName = $_POST['role'] ?? '';

        if (!Validator::required($name) || !Validator::alpha($name)) {
            $error = 'Nom invalide. Utilisez uniquement des lettres.';
        } elseif (!Validator::email($email)) {
            $error = 'Adresse email invalide.';
        } elseif (!Validator::minLength($password, 6)) {
            $error = 'Le mot de passe doit contenir au moins 6 caractères.';
        } elseif (!Validator::inArray($roleName, ['candidate', 'recruiter'])) {
            $error = 'Profil invalide sélectionné.';
        } elseif ($this->userRepository->findByEmail($email)) {
            $error = 'Cette adresse email est déjà utilisée.';
        }

        if (isset($error)) {
            Twig::display('auth/register.twig', [
                'error' => $error,
                'title' => 'Inscription',
                'post' => $_POST
            ]);
            return;
        }

        $role = $this->roleRepository->findByName($roleName);

        if (!$role) {
            $error = 'Profil non trouvé.';
            Twig::display('auth/register.twig', [
                'error' => $error,
                'title' => 'Inscription',
                'post' => $_POST
            ]);
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