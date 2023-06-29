<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    }

    public function callbackGoogle()
    {
        try {
            $google_user= Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $google_user->getEmail()],
                [
                    'google_id' => $google_user->getId(),
                    'username' => $google_user->getName()
                ]
            );


            Auth::login($user);
            return redirect(env('FRONT_END_BASE_URL') . '/news-feed');

        } catch(\Throwable $th) {
            return response()->json(['errors' => [__('validation.something_went_wrong')]], 400);
        }
    }
}
