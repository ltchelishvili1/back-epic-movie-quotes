<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    public function redirect(): string
    {
        return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    }

    public function callbackGoogle(): RedirectResponse|JsonResponse
    {
        try {

            $google_user= Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $google_user->getEmail()],
                [
                    'google_id' => $google_user->getId(),
                    'username' => $google_user->getName(),
                    'email_verified_at' => now()
                ]
            );

            Auth::login($user);

            return redirect(env('FRONT_END_BASE_URL') . '/news-feed');

        } catch(\Throwable $th) {

            return response()->json(['errors' => [__('validation.something_went_wrong')]], 400);

        }
    }
}
