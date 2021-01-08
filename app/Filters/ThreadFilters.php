<?php

namespace App\Filters;

use App\Models\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered'];
    /**
     * Filter the query by a given username
     *
     * @param  mixed $username
     * @return void
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    public function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }

    public function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
