<?php

namespace App\Traits;

use App\Favorite;
use Illuminate\Support\Facades\Auth;

/**
 * @property \Illuminate\Database\Eloquent\Collection|\App\Favorite[] $favorites
 */
trait Favoritable
{

    protected static function bootFavoritable(){
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorite()
    {
        $attributes = ['user_id' => Auth::id()];

        if ($this->favorites()->where($attributes)->exists()) {
            return null;
        }

        return $this->favorites()->create($attributes);
    }

    public function unfavorite()
    {
        $this->favorites()->where(['user_id' => Auth::id()])->get()->each->delete();
    }

    public function getIsFavoritedAttribute()
    {
        return  $this->isFavorited();
    }

    public function isFavorited()
    {
        return (bool) $this->favorites->where('user_id', Auth::id())->count();
    }

    /**
     * @return mixed
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
