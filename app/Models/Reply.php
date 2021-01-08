<?php

namespace App\Models;

use App\Traits\Favoritable;
use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    use Favoritable;
    use RecordActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $withCount = ['favorites'];

    protected $appends = ['favoritesCount', 'isFavorited'];

    protected static function boot()
    {
        parent::boot();

        self::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        self::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
