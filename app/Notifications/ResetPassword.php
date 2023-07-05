<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordBase;
use Illuminate\Support\Str;
use App\Models\PasswordReset;

class ResetPassword extends ResetPasswordBase
{
	public function toMail($notifiable): MailMessage
	{
		$token = Str::random(60);

		$modifiedEmail = base64_encode($notifiable->email);

		PasswordReset::updateOrCreate(
			[
				'email'      => $modifiedEmail,
				'token'      => $token,
				'created_at' => now(),
			]
		);

		return (new MailMessage())
		->subject(__('validation.reset_password'))
		->view(
			'email.reset-message',
			['url'  => env('FRONT_END_BASE_URL') . '/email-verify-token=' . $token . '/email=' . $modifiedEmail,
				'name' => $notifiable->name]
		);
	}

	public static function createUrlUsing($callback)
	{
		static::$createUrlCallback = $callback;
	}
}
