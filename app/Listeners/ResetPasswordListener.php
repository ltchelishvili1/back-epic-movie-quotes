<?php

namespace App\Listeners;

use App\Events\UserCreated;

class ResetPasswordListener
{
	/**
	 * Create the event listener.
	 */
	public function __construct()
	{
	}

	/**
	 * Handle the event.
	 */
	public function handle(UserCreated $event): void
	{
		$user = $event->user;
		if (isset($user->password)) {
			$user->PasswordHistories()->create([
				'password' => $user->password,
			]);
		}
	}
}
