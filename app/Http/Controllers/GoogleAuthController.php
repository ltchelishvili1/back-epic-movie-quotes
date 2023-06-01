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

            $user = User::where('google_id', $google_user->getId())->first();

            if(!$user) {
                $new_user = User::create([
                    'username' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId()
                ]);

                Auth::login($new_user);
                request()->session()->regenerate();
                return redirect(env('FRONT_END_BASE_URL') . '/landing');
            } else {
                Auth::login($user);
                request()->session()->regenerate();
                return redirect(env('FRONT_END_BASE_URL') . '/landing');
            }

            return response()->json('fe');


        } catch(\Throwable $th) {
            dd('something went wrong!' . $th->getMessage());
        }
    }
}
