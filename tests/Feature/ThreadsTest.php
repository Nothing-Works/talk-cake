<?php

namespace Tests\Feature;

use Tests\TestCase;

class ThreadsTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_a_user_can_view_thread()
    {
        $this->get('/threads')->assertStatus(200);
    }
}
