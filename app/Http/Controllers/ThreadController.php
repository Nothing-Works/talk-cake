<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Rules\Recaptcha;
use App\Rules\SpamFree;
use App\Thread;
use App\Trending;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
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
     * @param Trending      $trending
     *
     * @return Response
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        return view('threads.index', ['threads' => $threads, 'trending' => $trending->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Recaptcha                $recaptcha
     *
     * @return Response
     */
    public function store(Request $request, Recaptcha $recaptcha)
    {
        $request->validate([
            'title' => ['required', new SpamFree()],
            'body' => ['required', new SpamFree()],
            'channel_id' => 'required|exists:channels,id',
            'g-recaptcha-response' => ['required', $recaptcha],
        ]);

        $thread = Auth::user()
            ->threads()
            ->create([
                'title' => $request->input('title'),
                'body' => $request->input('body'),
                'channel_id' => $request->input('channel_id'),
            ]);

        return redirect($thread->path())->with('flash', 'Your thread has been published');
    }

    public function update(Channel $channel, Thread $thread, Request $request)
    {
        $this->authorize('update', $thread);

        return tap($thread)->update($request->validate([
            'title' => ['required', new SpamFree()],
            'body' => ['required', new SpamFree()],
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param Channel     $channel
     * @param \App\Thread $thread
     * @param Trending    $trending
     *
     * @return Response
     */
    public function show(Channel $channel, Thread $thread, Trending $trending)
    {
        if (Auth::user()) {
            Auth::user()->readThread($thread);
        }
        $trending->push($thread);

        $thread->newVisit();

        return view('threads.show', compact('thread'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Channel     $channel
     * @param \App\Thread $thread
     *
     * @return RedirectResponse|Redirector
     *
     * @throws Exception
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
     * @return LengthAwarePaginator
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::filter($filters)->latest();

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(5);
    }
}
