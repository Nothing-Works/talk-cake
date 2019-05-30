<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\ReplyForm;
use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
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
     * @return LengthAwarePaginator
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
     * @param ReplyForm                $form
     *
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request, Channel $channel, Thread $thread, ReplyForm $form)
    {
        if ($thread->locked) {
            return response('Thread was locked', 422);
        }

        return $thread->addReply([
            'body' => $request->input('body'),
            'user_id' => Auth::id(),
        ])->load('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Reply               $reply
     *
     * @return Response
     *
     * @throws AuthorizationException
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
     * @return Response
     *
     * @throws Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $status = $reply->delete();

        return response()->json($status);
    }
}
