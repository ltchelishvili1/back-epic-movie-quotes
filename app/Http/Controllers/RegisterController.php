<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        unset($validated['repeat_password']);
        $user = User::create($validated);
        return response()->json('success', 200);

    }
}
