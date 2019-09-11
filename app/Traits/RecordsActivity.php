<?php

namespace App\Traits;

use App\Activity;
use Illuminate\Support\Facades\Auth;

trait RecordsActivity
{
    /**
     * @return mixed
     */
    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activities()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activities()->create([
            'type' => $this->getActivityType($event),
            'user_id' => Auth::id(),
        ]);
    }

    protected function getActivityType($event)
    {
        return $event.'_'.strtolower(class_basename($this));
    }
}
