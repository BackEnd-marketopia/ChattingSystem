<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\registerRequest;
use App\Http\Requests\loginRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    protected $authService;


    // Constructor
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    // Register a new user
    public function register(registerRequest $request)
    {
        $result = $this->authService->register($request->validated());

        if (is_array($result)) {
            throw new HttpResponseException(
                Response::api($result['message'], 401, false, 401, null)
            );
        }

        return Response::api('User registered successfully', 201, true, 201, $request->except('password', 'password_confirmation'));
    }


    // Login a user
    public function login(loginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if (is_array($result)) {
            throw new HttpResponseException(
                Response::api($result['message'], 401, false, 401, null)
            );
        }

        $user = User::where('email', $request->email)->first(['id', 'name', 'email']);


        return Response::api('User logged in successfully', 200, true, 200, [
            'user' => array_merge(
                $user->toArray(),
                [
                    'role' => $user->getRoleNames()->first(),
                ]
            ),
            'token' => $result
        ], 200);
    }

    // Logout the currently authenticated user
    public function logout()
    {
        $result = $this->authService->logout();

        if (is_array($result)) {
            throw new HttpResponseException(
                Response::api($result['message'], 401, false, 401, null)
            );
        }

        return Response::api('User logged out successfully', 200, true, 200, null);
    }

    // Logout the currently authenticated user
    public function users()
    {
        $result = $this->authService->users();
        if (is_array($result)) {
            throw new HttpResponseException(
                Response::api($result['message'], 401, false, 401, null)
            );
        }
        return Response::api('Users retrieved successfully', 200, true, 200, $result);
    }

    // Get user by ID
    public function show($userId)
    {
        $result = $this->authService->show($userId);
        if (is_array($result)) {
            throw new HttpResponseException(
                Response::api($result['message'], 401, false, 401, null)
            );
        }
        return Response::api('User retrieved successfully', 200, true, 200, $result);
    }

    // Update user information
    public function update($userId, UpdateRequest $request)
    {
        $result = $this->authService->update($userId, $request->all());
        if (is_array($result)) {
            throw new HttpResponseException(
                Response::api($result['message'], 200, true, 0, 200, null)
            );
        }

        return Response::api('User Updated successfully', 200, true, 200, $result);
    }

    // Delete a user by ID
    public function destroy($userId)
    {
        $result = $this->authService->delete($userId);

        if (is_array($result)) {
            throw new HttpResponseException(
                Response::api($result['message'], 200, true, 0, 200, null)
            );
        }
        return Response::api('User Deleted successfully', 200, true, 200, $result);
    }
}
