<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends VerifyEmailBase
{
	public function toMail($notifiable): MailMessage
	{
		$url = $this->verificationUrl($notifiable);

		return (new MailMessage())
		->subject(__('validation.verification'))
		->view(
			'email.verify-message',
			[
				'url'  => $url,
				'name' => $notifiable->username,
			]
		);
	}
}
