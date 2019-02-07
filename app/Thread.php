<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 *
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
 *
 * @property \App\Channel $channel
 * @property int          $channel_id
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Thread whereChannelId($value)
 */
class Thread extends Model
{
    protected $guarded = [];

    public function path()
    {
        return '/threads/'.$this->channel->slug.'/'.$this->id;
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
        $this->replies()->create($attribute);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
