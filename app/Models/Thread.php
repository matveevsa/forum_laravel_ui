<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Thread extends Model
{
    use HasFactory;
    use RecordActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)->latest();
    }

    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }
}
