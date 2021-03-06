<?php

namespace App\Http\Controllers;

use App\Thread;

class LockThreadController extends Controller
{
    public function store(Thread $thread)
    {
        $thread->lockThread();

        return response('You locked a thread', 200);
    }

    public function destroy(Thread $thread)
    {
        $thread->unlockThread();

        return response('You unlocked a thread', 200);
    }
}
