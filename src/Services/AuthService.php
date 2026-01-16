<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Core\Session;

class AuthService
{
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;

    public function __construct()
    {
        Session::init();

        $this->userRepository = new UserRepository();
        $this->roleRepository = new RoleRepository();
    }

    /**
     * Login user
     */
    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        $role = $this->roleRepository->findById($user->getRole()->getId());

        Session::regenerate();

        Session::set('user_id', $user->getId());
        Session::set('role_id', $role->getId());
        Session::set('role_name', $role->getName());
        Session::set('logged_in', true);

        return true;
    }

    /**
     * Logout user
     */

    /**
     * Check if user is authenticated
     */
    public function isAuthenticated(): bool
    {
        return Session::get('logged_in') === true;
    }

    /**
     * Get current user role
     */
    public function getRole(): ?string
    {
        return Session::get('role_name');
    }

    /**
     * Require authentication
     */
    public function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            header('Location: /login');
            exit;
        }
    }

    public function logout(): void
    {
        Session::destroy();
        
        header('Location: /login');
        exit;
    }

    /**
     * Require a specific role
     */
    public function requireRole(string $role): void
    {
        $this->requireAuth();

        if ($this->getRole() !== $role) {
            http_response_code(403);
            require __DIR__ . '/../Views/errors/403.php';
            exit;
        }
    }

    /**
     * Redirect user after login based on role
     */
    public function redirectAfterLogin(): void
    {
        $role = $_SESSION['role_name'];

        switch ($role) {
            case 'candidate':
                header('Location: /candidate/dashboard');
                break;

            case 'recruiter':
                header('Location: /recruiter/dashboard');
                break;

            case 'admin':
                header('Location: /admin/dashboard');
                break;

            default:
                header('Location: /login');
        }

        exit;
    }
}
