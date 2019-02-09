<?php

namespace Tests\Feature;

use App\Reply;
use App\User;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    public function test_guests_can_not_favorite_anything()
    {
        $this->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_favorite_any_reply()
    {
        $this->actingAs(factory(User::class)->create());
        $reply = factory(Reply::class)->create();

        $this->post('/replies/'.$reply->id.'/favorites');

        $this->assertCount(1, $reply->favorites);
    }
}
