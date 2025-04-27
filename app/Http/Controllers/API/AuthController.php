<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\registerRequest;
use App\Http\Requests\loginRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    
    public function register(registerRequest $request)
    {
        $token = $this->authService->register($request->validated());
        return response()->json(['token' => $token], 201);
    }


    public function login(loginRequest $request)
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json(['token' => $token], 200);
    }
}
