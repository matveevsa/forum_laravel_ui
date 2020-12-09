<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create();
    }

    public function testThreadCanMakeStringPath()
    {
        $thread = create(Thread::class);

        $this->assertEquals(
            url()->current() . "/threads/{$thread->channel->slug}/{$thread->id}",
            route('threads.show', [$thread->channel, $thread])
        );
    }

    public function testHasCreator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    public function testHasReplies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    public function testCanAddReply()
    {
        $this->thread->addReply([
            'body' => 'FooBar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function testThreadBelontsToChannel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }
}
