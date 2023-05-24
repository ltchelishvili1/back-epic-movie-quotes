<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function getUser(): JsonResponse
    {

        return response()->json(
            [
                'message' => 'authenticated successfully',
                'user' => isUserAuth()
            ],
            200
        );
    }
}
