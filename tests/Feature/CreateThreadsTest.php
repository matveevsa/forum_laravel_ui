<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function testGuestMayNotCreateThreads()
    {
        $this->post(route('threads.store'))
            ->assertRedirect('login');

            $this->get(route('threads.create'))
            ->assertRedirect('login');
    }

    public function testAuthenticatedUserCanCreateThread()
    {
        $this->signIn();

        $thread = Thread::factory()->make();
        $response = $this->post(route('threads.store', $thread->toArray()));

        $this->get(route('threads.index'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function testThreadRequiresTitle()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function testThreadRequiresBody()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function testThreadRequiresChannel()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 222222222222])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post(route('threads.store', $thread->toArray()));
    }
}
