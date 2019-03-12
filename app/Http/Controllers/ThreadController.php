<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Rules\SpamFree;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    /**
     * ThreadController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel       $channel
     * @param ThreadFilters $filters
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function store(Request $request)
    {
        Auth::user()
            ->threads()
            ->create($request->validate([
                'title' => ['required', new SpamFree()],
                'body' => ['required', new SpamFree()],
                'channel_id' => 'required|exists:channels,id',
            ]));

        return redirect('/threads')->with('flash', 'Your thread has been published');
    }

    /**
     * Display the specified resource.
     *
     * @param Channel     $channel
     * @param \App\Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Thread $thread)
    {
        if (Auth::user()) {
            Auth::user()->readThread($thread);
        }

        return view('threads.show', compact('thread'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Channel     $channel
     * @param \App\Thread $thread
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @throws \Exception
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->replies->each->delete();

        $thread->delete();

        return redirect('/threads');
    }

    /**
     * @param Channel       $channel
     * @param ThreadFilters $filters
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Thread|Thread[]
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::filter($filters)->latest();

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }
}
