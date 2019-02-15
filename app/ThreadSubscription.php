<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ThreadSubscription.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription query()
 * @mixin \Eloquent
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $thread_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereUserId($value)
 * @property \App\User   $user
 * @property \App\Thread $thread
 */
class ThreadSubscription extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
