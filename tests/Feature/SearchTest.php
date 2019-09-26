<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;

class SearchTest extends TestCase
{
    public function test_a_user_can_search_threads()
    {
        $search = 'foobar';
        factory(Thread::class, 2)->create();
        factory(Thread::class, 2)->create(['body' => "A thread with the {$search} term."]);

        $result = $this->getJson("/threads/search?q={$search}")->json();
        $this->assertCount(2, $result);
    }
}
