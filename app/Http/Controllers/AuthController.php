<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
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
