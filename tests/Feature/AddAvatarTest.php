<?php

namespace Tests\Feature;

use Tests\TestCase;

class AddAvatarTest extends TestCase
{
    public function test_only_members_can_add_avatars()
    {
        $this->json('POST', '/api/users/1/avatar')
            ->assertStatus(401);

    }
}
