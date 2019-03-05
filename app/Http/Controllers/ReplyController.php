<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Reply;
use App\Inspections\Spam;
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
     * @param Spam                     $spam
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @throws \Exception
     */
    public function store(Request $request, Channel $channel, Thread $thread, Spam $spam)
    {
        $request->validate(['body' => 'required']);

        $spam->detect($request->input('body'));

        $reply = $thread->addReply([
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
        ]);

        return $reply->load('user');
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
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update($request->validate(['body' => 'required']));

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
