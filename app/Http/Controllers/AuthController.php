<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $fieldType = filter_var($validated['username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (auth()->attempt(
            [
            $fieldType => $validated['username'],
            'password' => $validated['password']],
            $validated['remember_me']
        )) {
            request()->session()->regenerate();
            return response()->json(['message'=>'successfully logged in'], 200);
        } else {
            return response()->json(['errors' => ['password' => ['Invalid credentials!']]], 404);
        }


    }



   public function logout(): JsonResponse
   {
       request()->session()->invalidate();
       request()->session()->regenerateToken();

       return response()->json(['message' => 'Logged out']);
   }



}
