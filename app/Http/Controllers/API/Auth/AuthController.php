<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function register(UserRequest $request)
    {
        try {
            $user = $this->authService->createUser($request->validated());

            return $this->okResponse('Account created', $user);
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }

    public function login(UserLoginRequest $request)
    {
        try {
            $user = $this->authService->login($request->validated());

            return $this->okResponse('Logged in successfully.', [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->token
            ]);
        } catch (Exception $e) {
            return $this->serverErrorResponse($e);
        }
    }
}
