<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Auth\Access\AuthorizationException;

class BestReplyController extends Controller
{
    /**
     * @param Reply $reply
     *
     * @throws AuthorizationException
     */
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);

        $reply->thread->setBestReply($reply);
    }
}
