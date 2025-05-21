<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->currentAccessToken()->delete();
        }
        return true;
    }

    public function users()
    {
        $users = User::paginate(10);
        $users->through(function ($user) {
            $user->role = $user->getRoleNames()->first();
            unset($user->roles);
            return $user;
        });
        return $users;
    }

    public function show($userId)
    {
        $user = User::findorFail($userId);
        $user->role = $user->getRoleNames()->first();
        unset($user->roles);
        return $user;
    }

    public function update($userId, $data)
    {
        $user = User::findorFail($userId);
        $user->update(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]
        );

        return $user;
    }

    public function delete($userId)
    {
        $user = User::findorFail($userId);
        $user->delete();
        return $user;
    }
}
