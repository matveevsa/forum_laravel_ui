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

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    public function testUserCanUnsubscribeToThreads()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->post($thread->path() . '/subscriptions');
        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->subscriptions);
    }
}
