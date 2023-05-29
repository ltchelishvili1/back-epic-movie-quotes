<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkTokenRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request)
    {
        $validated = $request->validated();
        $user = User::where('email', $validated['email'])->first();
        if(!$user) {
            return response()->json(['errors' => ['email' => ['User not found!']]], 404);
        }
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return response()->json($status);

    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $validated = $request->validated();
        $resetRequest = PasswordReset::where('token', $validated['token'])->where('email', $validated['email'])->first();
        if($resetRequest) {
            $email = base64_decode($validated['email']);
            User::where('email', $email)->first()->update(['password' => $validated['password']]);
            return response()->json(['message' => 'Password succesfuly changed', 200]);
        }

        return response()->json(['message' => 'Bad request'], 400);


    }

    public function checkToken(checkTokenRequest $request)
    {
        $validated = $request->validated();
        $resetRequest = PasswordReset::where('token', $validated['token'])
                            ->where('email', $validated['email'])
                            ->first();
        if(!$resetRequest) {
            return response()->json(['message' => 'Wrong Token'], 404);
        }
        if (Carbon::parse($resetRequest->created_at)->addHours(2) < Carbon::now()) {
            return response()->json(['message' => 'Token expired'], 401);
        }
        return response()->json(['message' => 'Correct Token'], 200);


    }

}
