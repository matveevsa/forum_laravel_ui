<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    public function testItRecordsActivityWhenThreadCreated()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function testRecordsActivityWhenReplyCreated()
    {
        $this->signIn();

        create(Reply::class);

        $this->assertEquals(2, Activity::count());
    }

    public function testFetchesFeedForAnyUser()
    {
        $this->signIn();

        create(Thread::class, ['user_id' => auth()->id()], 2);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('d-m-Y')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('d-m-Y')
        ));
    }
}
