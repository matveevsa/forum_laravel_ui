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

    public function testGuestCannotDeleteThread()
    {
        $thread = create(Thread::class);

        $this->delete(route('threads.destroy', [$thread->channel, $thread]))
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete(route('threads.destroy', [$thread->channel, $thread]))
            ->assertStatus(403);
    }

    public function testAuthorizeUserCanDeleteThreads()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $this->json('DELETE', route('threads.destroy', [$thread->channel, $thread]))
            ->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
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

    public function testUserCanFilterThreadsByPopularity()
    {
        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 3);

        $thredWithNoReplies = $this->thread;

        $response = $this->getJson('/threads?popular=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
