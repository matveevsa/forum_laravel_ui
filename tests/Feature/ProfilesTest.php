<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserHasProfile()
    {
        $user = create(User::class);

        $this->get("/profile/{$user->name}")
            ->assertSee($user->name);
    }

    public function testProfileDisplayAllThreadsCreatedUser()
    {
        $user = create(User::class);

        $thread = create(Thread::class, ['user_id' => $user->id]);

        $this->get("/profile/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
