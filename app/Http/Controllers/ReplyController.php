<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
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
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $request->validate(['body' => 'required']);

        $thread->addReply([
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
        ]);

        return redirect($thread->path())->with('flash', 'Your just left a reply');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Reply $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Reply $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Reply               $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
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

        $reply->favorites->each->delete();

        $reply->delete();

        return back();
    }
}
