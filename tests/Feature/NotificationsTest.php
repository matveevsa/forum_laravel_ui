<?php

namespace Tests\Feature;

use App\Models\DatabaseNotification as ModelsDatabaseNotification;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    public function testNotificationIsPreparedWhenSubscribedThreadRecievesNewReplyThatNotByTheCurrentUser()
    {
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
        create(ModelsDatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson("/profile/" . auth()->user()->name . "/notifications")->json()
        );
    }

    public function testUserCanMarkNotificationsAsRead()
    {
        create(ModelsDatabaseNotification::class);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profile/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
