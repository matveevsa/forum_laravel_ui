<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
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
        $this->get(route('threads.show', $this->thread))
            ->assertSee($this->thread->title);
    }

    public function testRepliesThatAssociatedWithThread()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);

        $this->get(route('threads.show', $this->thread))
            ->assertSee($reply->body);
    }
}
