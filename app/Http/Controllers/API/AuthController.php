<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\registerRequest;
use App\Http\Requests\loginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


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
}
