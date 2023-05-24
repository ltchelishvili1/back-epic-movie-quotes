<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JwtAuth
{
    public function handle(Request $request, Closure $next): JsonResponse | Closure
    {

        if ($request->cookie('access_token')) {
            $token = $request->cookie('access_token');
        } elseif ($request->header('Authorization') && strpos($request->header('Authorization'), 'Bearer ') === 0) {
            $token = substr($request->header('Authorization'), 7);
        } else {
            return response()->json(['message' => 'Token not present'], 401);
        }
        $user = User::where('session_token', $token)->first();

        if(!$user) {
            return response()->json(['message' => 'Invalid token!'], 401);
        }

        if ($user->expiration_date < Carbon::now()) {
            return response()->json(['message' => 'Token expired'], 401);
        }



        return $next($request);
    }
}
