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

    public function testThreadCanBeSubscribed()
    {
        $thread = create(Thread::class);

        $userId = 1;

        $thread->subscribe($userId);

        $this->assertEquals(
            1,
            $thread->subscriptions()->where('user_id', $userId)->count()
        );
    }

    public function testThreadCanBeUnsubscribed()
    {
        $thread = create(Thread::class);

        $userId = 1;

        $thread->subscribe($userId);

        $thread->unsubscribe($userId);

        $this->assertEquals(0, $thread->subscribes);
    }


    public function testItknowsIfTheAuthenticatedUserIsSubscriberToIt()
    {
        $thread = create(Thread::class);
        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }
}
