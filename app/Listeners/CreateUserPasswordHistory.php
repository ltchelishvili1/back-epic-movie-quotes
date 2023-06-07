<?php

namespace App\Listeners;

use App\Events\UserCreated;

class CreateUserPasswordHistory
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->user;
        $password = isset($user->password) ? $user->password : null;

        $user->PasswordHistories()->create([
            'user_id' => $user->id,
            'password' => $password,
        ]);
    }
}
