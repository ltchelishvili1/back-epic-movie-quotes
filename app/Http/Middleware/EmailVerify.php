<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmailVerify
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle($request, Closure $next)
	{
		if (!$request->user() || !$request->user()->hasVerifiedEmail()) {
			return response()->json(['error' => __('validation.email_verification_required')], 403);
		}
		return $next($request);
	}
}
