<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered'];

    /**
     * @param $username
     *
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->query->where('user_id', $user->id);
    }

    protected function popular()
    {
        return $this->query->orderBy('replies_count', 'desc');
    }

    protected function unanswered()
    {
        return $this->query->having('replies_count', 0);
    }
}
