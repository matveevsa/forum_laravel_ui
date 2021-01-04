<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Favorite;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    public function testGuestCannotFavoriteAnything()
    {
        $this->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    public function testAuthenticatedUserCanFavoriteAnyReply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function testAuthenticatedUserCanUnfavoriteReply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $reply->favorite();
        $reply->unfavorite();
        $this->assertCount(0, $reply->favorites);
    }

    public function testAuthenticatedUserMayOnlyFavoriteReplyOnce()
    {
        $this->signIn();
        $this->withoutExceptionHandling();
        $reply = create(Reply::class);
        try {
            $this->post('/replies/' . $reply->id . '/favorites');
            $this->post('/replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
