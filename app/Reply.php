<?php

namespace App;

use App\Traits\Favoritable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Reply.
 *
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $thread_id
 * @property string                          $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Thread                     $thread
 * @property \App\User                       $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereUserId($value)
 * @mixin \Eloquent
 * @property \Illuminate\Database\Eloquent\Collection|\App\Favorite[] $favorites
 * @property-read mixed $favorites_count
 */
class Reply extends Model
{
    use Favoritable;
    protected $guarded = [];

    protected $with = ['user', 'favorites'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
