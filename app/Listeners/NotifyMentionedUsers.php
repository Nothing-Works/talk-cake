<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUsers
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
        $event
            ->reply
            ->mentionedUsers()
            ->each(function (User $user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
