<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
    public function toMail($notifiable): MailMessage
    {

        $url = $this->verificationUrl($notifiable);
        return (new MailMessage())
        ->subject('verify')
        ->view(
            'email.verify-message',
            [   'url' => $url,
                'name' => $notifiable->username]
        );
    }

}
