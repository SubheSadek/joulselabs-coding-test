<?php

declare(strict_types=1);

namespace SellNow\Services;

use SellNow\Core\Request;
use SellNow\Core\Validation\ValidationResult;
use SellNow\Core\Validation\Validator;
use SellNow\Domain\User;
use SellNow\Repositories\UserRepository;

class AuthService
{
    public function __construct(
        private UserRepository $userRepo
    ) {}

    /**
     * Validate register data
     */
    public function validateRegisterData(Request $request): array
    {
        $errors = [];

        $user = $this->userRepo->findByEmailOrUsername($request->input('email'), $request->input('username'));

        if (! empty($user)) {
            $errors[] = 'Invalid email address or username.';
        }

        return $errors;
    }

    /**
     * Register a new user
     */
    public function register(Request $request): User
    {
        $passwordHash = password_hash($request->input('password'), PASSWORD_BCRYPT);

        $user = $this->userRepo->create(
            $request->input('email'),
            $passwordHash,
            $request->input('username'),
            $request->input('full_name')
        );

        return $user;
    }

    /**
     * Login a user.
     */
    public function validateLoginData(Request $request, ?User $user): array
    {
        $errors = [];


        if (empty($user)) {
            $errors[] = 'Invalid email address.';
        }

        if (! empty($user) && ! password_verify($request->input('password'), $user->passwordHash())) {
            $errors[] = 'Invalid password.';
        }

        return $errors;
    }

    /**
     * Validate login request
     */
    public function validateLoginRequest(array $data): ValidationResult
    {
        $validator = new Validator();

        return $validator->validate($data, [
            'email' => 'required|string|max:255|email',
            'password' => 'required|string|max:255|min:8',
        ]);
    }

    /**
     * Validate register request
     */
    public function validateRegisterRequest(array $data): ValidationResult
    {
        $validator = new Validator();

        return $validator->validate($data, [
            'email' => 'required|string|max:255|email',
            'username' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|max:255|min:8|confirmed',
        ]);
    }

    /**
     * Format register request
     */
    public function formatRegisterRequest(Request $request): array
    {
        return [
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'full_name' => $request->input('full_name'),
            'password' => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
        ];
    }
}