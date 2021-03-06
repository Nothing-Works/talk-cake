<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Filters\ThreadFilters;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Stevebauman\Purify\Facades\Purify;

/**
 * App\Thread.
 *
 * @property int                                                   $id
 * @property int                                                   $user_id
 * @property string                                                $title
 * @property string                                                $body
 * @property \Illuminate\Support\Carbon|null                       $created_at
 * @property \Illuminate\Support\Carbon|null                       $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Reply[] $replies
 * @property \App\User                                             $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereUserId($value)
 * @mixin \Eloquent
 * @property \App\Channel $channel
 * @property int          $channel_id
 * @method static                                                  \Illuminate\Database\Eloquent\Builder|\App\Thread whereChannelId($value)
 * @method static\Illuminate\Database\Eloquent\Builder|\App\Thread filter($filters)
 * @property \Illuminate\Database\Eloquent\Collection|\App\Activity[]           $activities
 * @property \Illuminate\Database\Eloquent\Collection|\App\ThreadSubscription[] $subscriptions
 * @property mixed                                                              $is_subscribed
 * @property int                                                                $visits
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereVisits($value)
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereSlug($value)
 * @property int|null $best_reply_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereBestReplyId($value)
 * @property int $locked
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereLocked($value)
 * @property int|null $activities_count
 * @property int|null $replies_count
 * @property int|null $subscriptions_count
 */
class Thread extends Model
{
    use RecordsActivity;
    use Searchable;

    protected $guarded = [];

    protected $with = ['user', 'channel'];

    protected $appends = ['isSubscribed'];

    protected $casts = [
        'locked' => 'boolean',
    ];

    public function path()
    {
        return '/threads/'.$this->channel->slug.'/'.$this->slug;
    }

    public function unsubscribe()
    {
        return $this->subscriptions()->where('user_id', Auth::id())->delete();
    }

    public function getIsSubscribedAttribute()
    {
        return (bool) $this->subscriptions()->where('user_id', Auth::id())->exists();
    }

    public function toSearchableArray()
    {
        return $this->toArray() + ['path' => $this->path()];
    }

    public function subscribe()
    {
        $this->subscriptions()->create([
           'user_id' => Auth::id(),
        ]);

        return $this;
    }

    public function lockThread()
    {
        $this->update(['locked' => true]);
    }

    public function unlockThread()
    {
        $this->update(['locked' => false]);
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addReply($attribute)
    {
        $reply = $this->replies()->create($attribute);

        event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    public function notifySubscribers($reply)
    {
        $this->subscriptions
                ->where('user_id', '!=', $reply->user_id)
                ->each
                ->notify($reply);
    }

    public function newVisit()
    {
        $this->increment('visits');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function hasUpdate()
    {
        return $this->updated_at > Cache::get(Auth::user()->visitedThreadCacheKey($this));
    }

    /**
     * Scope a query to only include active users.
     *
     *@param ThreadFilters $filters
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $slug = "${slug}-".$this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    public function setBestReply(Reply $reply)
    {
        $this->update(['best_reply_id' => $reply->id]);
    }

    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
    }

    /**
     * The "booting" method of the model.
     *
     * @param Builder
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function (Builder $builder) {
            $builder->withCount('replies');
        });

        static::created(function (Thread $thread) {
            $thread->update(['slug' => $thread->title]);
        });
    }
}
