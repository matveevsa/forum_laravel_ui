<?php

namespace Tests\Feature;

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
        $this->post(route('threads.store', $thread->toArray()));

        $this->get(route('threads.index'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
