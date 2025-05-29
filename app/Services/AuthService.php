<?php

namespace App\Services;

use App\Repositories\Auth\AuthRepositoryInterface;

class AuthService
{
    protected $authRepo;

    // Constructor
    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    // Register a new user
    public function register(array $data)
    {
        return $this->authRepo->register($data);
    }

    // Login a user with given credentials
    public function login(array $credentials)
    {
        return $this->authRepo->login($credentials);
    }

    // Logout the currently authenticated user
    public function logout()
    {
        return $this->authRepo->logout();
    }

    // Get the currently authenticated user
    public function users()
    {
        return $this->authRepo->users();
    }

    // Get user by ID
    public function show($userId)
    {
        return $this->authRepo->show($userId);
    }

    // Update user information
    public function update($userId, array $data)
    {
        return $this->authRepo->update($userId, $data);
    }

    // Delete a user by ID
    public function delete($userId)
    {
        return $this->authRepo->delete($userId);
    }
}
