<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class VerifyEmailBase extends VerifyEmail
{
	/**
	 * Get the verification URL for the given notifiable.
	 *
	 * @param mixed $notifiable
	 *
	 * @return string
	 */
	protected function verificationUrl($notifiable)
	{
		if (static::$createUrlCallback) {
			return call_user_func(static::$createUrlCallback, $notifiable);
		}

		return URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'   => $notifiable->getKey(),
				'hash' => $notifiable->getEmailForVerification(),
			]
		);
	}
}
