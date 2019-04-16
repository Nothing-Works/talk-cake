<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * App\User.
 *
 * @property \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 *
 * @property int                                                    $id
 * @property string                                                 $name
 * @property string                                                 $email
 * @property string|null                                            $email_verified_at
 * @property string                                                 $password
 * @property string|null                                            $remember_token
 * @property \Illuminate\Support\Carbon|null                        $created_at
 * @property \Illuminate\Support\Carbon|null                        $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Reply[]  $replies
 * @property \Illuminate\Database\Eloquent\Collection|\App\Thread[] $threads
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 *
 * @property \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property \App\Reply                                               $lastReply
 * @property string|null                                              $avatar_path
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatarPath($value)
 *
 * @property int $confirmed
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereConfirmed($value)
 *
 * @property string|null $confirmation_token
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereConfirmationToken($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'confirmation_token', 'confirmed',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
    ];

    public function getAvatarPathAttribute($avatar): string
    {
        return $avatar ? Storage::url($avatar) : '/img/default.jpg';
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function confirm()
    {
        $this->update(['confirmed' => true]);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class)
            ->latest();
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function readThread($thread)
    {
        Cache::forever(Auth::user()->visitedThreadCacheKey($thread), Carbon::now());
    }

    public function visitedThreadCacheKey($thread)
    {
        return sprintf('users.%s.visits.%s', $this->id, $thread->id);
    }
}
