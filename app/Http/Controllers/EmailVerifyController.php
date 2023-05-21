<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    public function emailVerify(Request $request): JsonResponse
    {
        $user = User::find($request->id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        return response()->json(['message' => 'Successfully verified'], 200);
    }
}
