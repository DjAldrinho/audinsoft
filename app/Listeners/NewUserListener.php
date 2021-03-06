<?php

namespace App\Listeners;

use App\Events\NewUserEvent;
use App\Notifications\NewUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewUserEvent $event
     * @return void
     */
    public function handle(NewUserEvent $event)
    {
        $event->user->notify(new NewUser());
    }
}
