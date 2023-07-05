<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class EnsureEmailVerified
{
	public function handle($request, Closure $next)
	{
		$user = User::where('email', $request->all()['username'])->orWhere('username', $request->all()['username'])->first();

		if ($user && $user->email_verified_at === null) {
			return response()->json(['errors' => ['password' => [__('validation.email_not_verified')]]], 404);
		} else {
			return $next($request);
		}
	}
}
