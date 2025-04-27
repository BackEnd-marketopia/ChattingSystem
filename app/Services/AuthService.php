<?php

namespace App\Services;

use App\Repositories\Auth\AuthRepositoryInterface;

class AuthService
{
    protected $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function register(array $data)
    {
        return $this->authRepo->register($data);
    }

    public function login(array $credentials)
    {
        return $this->authRepo->login($credentials);
    }
}
