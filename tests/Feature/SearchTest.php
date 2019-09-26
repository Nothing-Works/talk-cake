<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;

class SearchTest extends TestCase
{
    public function test_a_user_can_search_threads()
    {
        config(['scout.driver' => 'algolia']);
        $search = 'foobar';
        factory(Thread::class, 2)->create();
        factory(Thread::class, 2)->create(['body' => "A thread with the {$search} term."]);
        do {
            sleep(.25);
            $result = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while (empty($result));
        $this->assertCount(2, $result);

        Thread::latest()->take(4)->unsearchable();
    }
}
