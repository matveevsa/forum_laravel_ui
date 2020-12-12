<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create();
    }

    public function testIndex()
    {
        $this->get(route('threads.index'))
            ->assertSee($this->thread->title);
    }

    public function testShow()
    {
        $this->get(route('threads.show', [$this->thread->channel, $this->thread]))
            ->assertSee($this->thread->title);
    }

    public function testRepliesThatAssociatedWithThread()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);

        $this->get(route('threads.show', [$this->thread->channel, $this->thread]))
            ->assertSee($reply->body);
    }

    public function testUserCanFilterThreadsAccordingChannel()
    {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadInNotChannel = create(Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadInNotChannel->title);
    }

    public function testUserCanFilterThreadsByAnyUsername()
    {
        $this->signIn(create(User::class, ['name' => 'JohnDoe']));

        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);
        $threadByNotJohn = create(Thread::class);
        $this->get(route('threads.index', ['by' => 'JohnDoe']))
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadByNotJohn->title);
    }
}
