<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
    public function toMail($notifiable): MailMessage
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage())

        ->subject(__('verification'))
        ->view(
            'email.verify-message',
            [
                 'url' => $url,
                'name' => $notifiable->username
            ]
        );
    }

}
