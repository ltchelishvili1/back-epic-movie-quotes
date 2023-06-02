<?php

use App\Models\PasswordHistory;

function isUserAuth()
{
    $user = auth()->user();
    return response()->json(['user'=>$user]);
}

function addPasswordHistory($email, $password)
{

    PasswordHistory::create([
        'email' => $email,
        'password' => $password
    ]);
}
