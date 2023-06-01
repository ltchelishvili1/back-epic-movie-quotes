<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
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
            'email_verified_at' => '!='
            ],
            $validated['remember_me']
        )) {
            request()->session()->regenerate();
            return response()->json(['message'=>'successfully logged in'], 200);
        } else {
            $user = User::where($fieldType, $validated['username'])->first();

            if ($user && $user->email_verified_at === null) {
                return response()->json(['errors' => ['password' => [__('validation.please_verify_email')]]], 404);

            }
            return response()->json(['errors' => ['password' => [__('validation.invalid_credentials')]]], 404);
        }


    }



   public function logout(): JsonResponse
   {
       request()->session()->invalidate();
       request()->session()->regenerateToken();

       return response()->json(['message' => 'Logged out']);
   }



}
