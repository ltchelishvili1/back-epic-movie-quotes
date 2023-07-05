<?php

use App\Models\PasswordHistory;

function addPasswordHistory($user_id, $password)
{
	if (isset($password)) {
		PasswordHistory::create([
			'user_id'  => $user_id,
			'password' => $password,
		]);
	}
}
