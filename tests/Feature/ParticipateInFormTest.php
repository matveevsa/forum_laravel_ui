<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInFormTest extends TestCase
{
    use DatabaseMigrations;

    public function testUnauthenticatedUserMayNotAddReply()
    {
        $this->post('/threads/1/replies', [])->assertRedirect('login');
    }

    public function testAuthenticatedUserMayParticipateInForumThreads()
    {
        $this->be($user = create(User::class));
        $thread = create(Thread::class);

        $reply = make(Reply::class, ['user_id' => $user->id]);
        $this->post(route('replies.store', $thread), $reply->toArray());

        $this->get(route('threads.show', $thread))
            ->assertSee($reply->body);
    }
}
