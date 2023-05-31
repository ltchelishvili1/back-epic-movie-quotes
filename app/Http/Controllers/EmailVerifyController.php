<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    public function emailVerify(Request $request)
    {
        $user = User::find($request->id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return redirect(
                env('FRONT_END_BASE_URL') . '/account-activated'
            );
        } else {
            return response()->json(['message' => 'already verified'], 400);
        }
    }
}
