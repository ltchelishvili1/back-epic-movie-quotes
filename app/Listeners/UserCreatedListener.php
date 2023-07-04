<?php

namespace App\Listeners;

use App\Events\UserCreated;

class UserCreatedListener
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

        $user->thumbnail = url(asset('images/NoUserImage.png'));

        $user->save();
    }
}
