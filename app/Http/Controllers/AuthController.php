<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
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

            return response()->json(['user' => new UserResource(auth()->user()),'message'=> __('validation.successfully_logged_in')], 200);

        } else {

            return response()->json(['errors' => ['password' => [__('validation.invalid_credentials')]]], 404);
        }

    }

    public function logut(): JsonResponse
    {
        auth()->user()->logout;

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return response()->json(['message' => __('validation.logged_out')])->withCookie(cookie()->forget('XSRF-TOKEN'));

    }

    public function register(RegisterRequest $request): JsonResponse
    {

        $validated = $request->validated();

        $user = User::create(
            [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password']]
        );

        event(new Registered($user));

        return response()->json(['success' => __('validation.registered_successfully')], 201);
    }




}
