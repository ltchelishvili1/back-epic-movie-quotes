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

        if (auth()->attempt(
            [
            $fieldType => $validated['username'],
            'password' => $validated['password'],
            ],
            $validated['remember_me']
        )) {

            request()->session()->regenerate();

            return response()->json(['user' => auth()->user(),'message'=> __('validation.successfully_logged_in')], 200);

        } else {

            return response()->json(['errors' => ['password' => [__('validation.invalid_credentials')]]], 404);
        }

    }

    public function logut(): JsonResponse
    {
        auth()->user()->logout;

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return response()->json(['message' => 'Logged out'])->withCookie(cookie()->forget('XSRF-TOKEN'));

    }




}
