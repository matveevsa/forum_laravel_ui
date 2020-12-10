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
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->post(route('replies.store', $thread), $reply->toArray());

        $this->get(route('threads.show', [$thread->channel, $thread]))
            ->assertSee($reply->body);
    }

    public function testReplyRequiresBody()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);

        $this->post(route('replies.store', $thread), $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
