<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    }

    public function callbackGoogle()
    {
        try {
            $google_user= Socialite::driver('google')->stateless()->user();

            $user = User::firstWhere('google_id', $google_user->getId());

            if(!$user) {
                $user = User::create([
                    'username' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId()
                ]);
            }
            Auth::login($user);
            return redirect(env('FRONT_END_BASE_URL') . '/landing');

        } catch(\Throwable $th) {
            return response()->json(['errors' => ['password' => [__('validation.something_went_wrong')]]], 404);
        }
    }
}
