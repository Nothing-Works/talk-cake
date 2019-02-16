<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;

class NotifyThreadSubscribers
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param ThreadHasNewReply $event
     */
    public function handle(ThreadHasNewReply $event)
    {
        $event->thread->notifySubscribers($event->reply);
    }
}
