<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    public function testChannelConsistsThreads()
    {
        $channel = create(Channel::class);
        $thread = create(Thread::class, ['channel_id' => $channel->id]);
        
        $this->assertTrue($channel->threads->contains($thread));
    }
}
