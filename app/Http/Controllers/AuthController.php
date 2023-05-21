<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();
        unset($validated['repeat_password']);
        $user = User::create($validated);
        event(new Registered($user));
        return response()->json('success', 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $fieldType = filter_var($validated['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!auth()->attempt([$fieldType => $validated['username'], 'password' => $validated['password']], $request->input('remember_me'))) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(['success' => 'Login successful'], 200);
    }



}
