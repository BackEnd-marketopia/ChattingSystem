<?php


namespace App\Repositories\Auth;

interface AuthRepositoryInterface
{
    public function register(array $data);
    public function login(array $credentials);
    public function logout();
    public function users();
    public function show($userId);
    public function update($userId, array $data);
    public function delete($userId);
}
