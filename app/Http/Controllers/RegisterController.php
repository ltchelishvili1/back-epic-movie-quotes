<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {

        $validated = $request->validated();
        $user = User::create(
            [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password']]
        );
        $token =  $user->createToken('MyApp')->plainTextToken;
        event(new Registered($user));
        return response()->json(['success' => 'Register successful', 'token' => $token], 201);
    }
}
