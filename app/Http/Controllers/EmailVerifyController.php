<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
	public function emailVerify(Request $request, $id, $hash): RedirectResponse
	{
		$user = User::find($request->id);

		$user->email = $hash;

		$user->save();

		$user->markEmailAsVerified();

		return redirect(
			env('FRONT_END_BASE_URL') . '/account-activated'
		);
	}
}
