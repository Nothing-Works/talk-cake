<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Activity.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity query()
 * @mixin \Eloquent
 * @property \Illuminate\Database\Eloquent\Model|\Eloquent $subject
 * @property \Illuminate\Database\Eloquent\Model|\Eloquent $activity
 * @property int                                           $id
 * @property int                                           $user_id
 * @property int                                           $subject_id
 * @property string                                        $subject_type
 * @property string                                        $type
 * @property \Illuminate\Support\Carbon|null               $created_at
 * @property \Illuminate\Support\Carbon|null               $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUserId($value)
 */
class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * @param User $user
     * @param int  $take
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public static function feed(User $user, int $take = 50)
    {
        return static::where('user_id', $user->id)
                ->latest()
                ->with('subject')
                ->take($take)
                ->get()
                ->groupBy(function ($activity) {
                    return $activity->created_at->format('Y-m-d');
                });
    }
}
