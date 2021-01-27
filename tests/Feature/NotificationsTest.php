<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function testNotificationIsPreparedWhenSubscribedThreadRecievesNewReplyThatNotByTheCurrentUser()
    {
        $this->signIn();

        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function testUserCanFetchTheirUnreadNotifications()
    {
        $this->signIn();
        $user = auth()->user();
        $thread = create(Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply here'
        ]);

        $response = $this->getJson("/profile/{$user->name}/notifications")->json();

        $this->assertCount(1, $response);
    }

    public function testUserCanMarkNotificationsAsRead()
    {
        $this->signIn();

        $thread = create(Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'Some reply here'
        ]);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profile/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
