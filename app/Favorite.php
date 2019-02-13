<?php

namespace App;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Favorite.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite query()
 * @mixin \Eloquent
 * @property int                             $id
 * @property int                             $user_id
 * @property int                             $favorited_id
 * @property string                          $favorited_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereFavoritedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereFavoritedType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereUserId($value)
 * @property \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property \Illuminate\Database\Eloquent\Model|\Eloquent            $favorited
 */
class Favorite extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function favorited()
    {
        return $this->morphTo();
    }
}
