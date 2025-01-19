<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private User $user) {}

    public function createUser(array $data)
    {
        $newUser = $this->user->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $newUser->token = $newUser->createToken('MyApp')->plainTextToken;

        return $newUser;
    }

    public function login(array $data)
    {
        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;
            $user->token = $token;

            return $user;
        }

        throw new Exception('Invalid credentials.');
    }
}
