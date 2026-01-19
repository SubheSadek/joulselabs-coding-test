<?php

declare(strict_types=1);

namespace SellNow\Controllers;

use SellNow\Core\Request;
use SellNow\Core\Security\Csrf;
use SellNow\Core\Validation\Validator;
use SellNow\Repositories\UserRepository;
use SellNow\Services\AuthService;
use Twig\Environment;

class AuthController
{
    public function __construct(
        private Environment $twig,
        private AuthService $authService,
        private UserRepository $userRepo
    ) {}

    /**
     * Get login form.
     */
    public function loginForm(): void
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit;
        }

        echo $this->twig->render('auth/login.html.twig');
    }

    /**
     * Login a user.
     */
    public function login(Request $request): void
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        $result = $this->authService->validateLoginRequest($data);

        if ($result->fails()) {
            echo $this->twig->render('auth/login.html.twig', [
                'errors' => $result->errors(),
                'old' => $data,
            ]);

            exit;
        }

        $user = $this->userRepo->findByEmail($request->input('email'));

        $errors = $this->authService->validateLoginData($request, $user);

        if (! empty($errors)) {
            echo $this->twig->render('auth/login.html.twig', [
                'custom_errors' => $errors,
                'old' => $data,
            ]);

            exit;
        }

        session_regenerate_id(true);
        Csrf::regenerate();

        $_SESSION['user_id'] = $user->id();
        $_SESSION['username'] = $user->username();
        $_SESSION['email'] = $user->email();

        header("Location: /dashboard");
        exit;
    }

    /**
     * Get register form.
     */
    public function registerForm(): void
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit;
        }

        echo $this->twig->render('auth/register.html.twig');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request): void
    {
        $data = $this->authService->formatRegisterRequest($request);

        $result = $this->authService->validateRegisterRequest($data);

        if ($result->fails()) {
            echo $this->twig->render('auth/register.html.twig', [
                'errors' => $result->errors(),
                'old' => $data,
            ]);

            exit;
        }

        $errors = $this->authService->validateRegisterData($request);

        if (! empty($errors)) {
            echo $this->twig->render('auth/register.html.twig', [
                'custom_errors' => $errors,
                'old' => $data,
            ]);

            exit;
        }

        $user = $this->authService->register($request);

        header("Location: /login?msg=Registered successfully");
        exit;
    }

    /**
     * Get dashboard.
     */
    public function dashboard(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        echo $this->twig->render('dashboard.html.twig', [
            'username' => $_SESSION['username']
        ]);
    }

    /**
     * Logout a user.
     */
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        session_regenerate_id(true);
        Csrf::regenerate();
        header("Location: /login");
        exit;
    }
}