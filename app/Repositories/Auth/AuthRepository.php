<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function register(array $data)
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);


        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }

        return $user->createToken('api_token')->plainTextToken;
    }

    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return ['error' => 'email', 'message' => 'Email not found'];
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return ['error' => 'password', 'message' => 'Invalid password'];
        }

        return $user->createToken('api_token')->plainTextToken;
    }
}
