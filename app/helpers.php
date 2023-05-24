<?php

use App\Models\User;

function isUserAuth()
{
    try {
        if (!request()->cookie('access_token') && !request()->header('Authorization')) {
            throw new \ErrorException('Token is not provided');
        }

        $user = User::where('session_token', request()->cookie('access_token'))->first();

        if (!$user) {
            throw new \ErrorException('User not found');
        }

        return $user;
    } catch (\Exception $e) {
        return null;
    }
}
