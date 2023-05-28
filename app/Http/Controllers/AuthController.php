<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
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
            'password' => $validated['password']],
            $validated['remember_me']
        )) {

            $user = $request->user();

            $token = $user->createToken('authToken')->plainTextToken;

            $user ->update([
                'session_token' => $token,
                'expiration_date' => Carbon::now()->addMinutes(30)
            ]);
            $cookie = cookie("access_token", $token, 30);
            return response()->json(['token' => $token])->withCookie($cookie);
        } else {
            return response()->json(['errors' => ['password' => ['Invalid credentials!']]], 404);
        }


    }



   public function logout(): JsonResponse
   {
       $cookie = cookie("access_token", '', 0);
       return response()->json(['message' => 'Successfully logged out'])->withCookie($cookie);
   }



}
