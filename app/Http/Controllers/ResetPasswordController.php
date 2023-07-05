<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPassword\CheckTokenRequest;
use App\Http\Requests\ResetPassword\ResetPasswordRequest;
use App\Http\Requests\ResetPassword\UpdatePasswordRequest;
use App\Models\PasswordHistory;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {

        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if(!$user) {

            return response()->json(['errors' => ['email' => [__('validation.user_not_found')]]], 404);

        }
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json($status);

    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {

        $validated = $request->validated();

        $resetRequest = PasswordReset::where('token', $validated['token'])->where('email', $validated['email'])->first();

        if($resetRequest) {

            $email = base64_decode($validated['email']);

            $user =  User::where('email', $email)->first();

            $password = $validated['password'];

            $passwordHistoryMatch = PasswordHistory::where('user_id', $user->id)->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->filter(function ($history) use ($password) {
                return Hash::check($password, $history->password);
            })
            ->isNotEmpty();

            if($passwordHistoryMatch) {
                return response()->json(['errors' => ['password' => [__('validation.password_has_been_used')]]], 400);
            }

            if($user->google_id != null) {
                return response()->json(['errors' => ['password' => [__('validation.sign_in_with_google')]]], 400);
            }


            $user->update(['password' => $validated['password']]);

            addPasswordHistory($user->id, $user->password);

            return response()->json(['message' => __('validation.password_successfully_changed'), 200]);
        }

        return response()->json(['message' => __('validation.bad_request')], 400);


    }

    public function checkToken(CheckTokenRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $resetRequest = PasswordReset::where('token', $validated['token'])
                            ->where('email', $validated['email'])
                            ->first();

        if(!$resetRequest) {

            return response()->json(['message' => __('validation.wrong_token')], 404);

        }
        if (Carbon::parse($resetRequest->created_at)->addHours(2) < Carbon::now()) {

            return response()->json(['message' => __('valdiation.token_expired')], 401);

        }

        return response()->json(['message' => __('validation.correct_token')], 200);


    }

}
