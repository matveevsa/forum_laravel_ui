<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserCanSubscribeToThreads()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->post($thread->path() . '/subscriptions');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);

        // $this->assertCount(1, auth()->user()->notifications);
    }
}
