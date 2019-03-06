<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    /**
     * ReplyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param Thread  $thread
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Channel $channel, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Channel                  $channel
     * @param Thread                   $thread
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Channel $channel, Thread $thread)
    {
        $request->validate(['body' => ['required', new SpamFree()]]);

        $reply = $thread->addReply([
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
        ]);

        return $reply->load('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Reply               $reply
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $request->validate(['body' => ['required', new SpamFree()]]);

        $reply->update($request->only('body'));

        return response()->json($reply->fresh()->body);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Reply $reply
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);
        $status = $reply->delete();

        return response()->json($status);
    }
}
