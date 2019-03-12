<?php

namespace App;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
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
 *
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
 *
 * @property \Illuminate\Database\Eloquent\Collection|\App\Favorite[] $favorites
 * @property mixed                                                    $favorites_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property mixed                                                    $is_favorited
 */
class Reply extends Model
{
    use Favoritable,RecordsActivity;
    protected $guarded = [];
    protected $touches = ['thread'];
    protected $with = ['user', 'favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function mentionedUsers()
    {
        preg_match_all('/\@([^\s\.]+)/', $this->body, $matches);

        return  User::whereIn('name', $matches[1])->get();
    }

    public function path()
    {
        return $this->thread->path().'#reply-'.$this->id;
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }
}
