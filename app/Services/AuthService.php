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

    public function logout()
    {
        return $this->authRepo->logout();
    }

    public function users()
    {
        return $this->authRepo->users();
    }

    public function show($userId)
    {
        return $this->authRepo->show($userId);
    }

    public function update($userId, array $data)
    {
        return $this->authRepo->update($userId, $data);
    }

    public function delete($userId)
    {
        return $this->authRepo->delete($userId);
    }
}
