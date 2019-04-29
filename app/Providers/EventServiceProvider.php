<?php

namespace App\Providers;

use App\Events\ThreadHasNewReply;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\NotifyThreadSubscribers;
use App\Listeners\SendEmailConfirmationRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
//            SendEmailConfirmationRequest::class,
        ],
        ThreadHasNewReply::class => [
            NotifyThreadSubscribers::class,
            NotifyMentionedUsers::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}
