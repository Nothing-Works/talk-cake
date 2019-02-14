<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use App\ThreadSubscription;
use Illuminate\Http\Request;

class ThreadSubscriptionController extends Controller
{
    /**
     * ThreadSubscriptionController constructor.
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
     * @param Channel $channel
     * @param Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function store(Channel $channel, Thread $thread)
    {
        return   $thread->subscribe();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ThreadSubscription $threadSubscription
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ThreadSubscription $threadSubscription)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\ThreadSubscription $threadSubscription
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ThreadSubscription $threadSubscription)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\ThreadSubscription  $threadSubscription
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThreadSubscription $threadSubscription)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Channel $channel
     * @param Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel,Thread $thread)
    {
        return $thread->unsubscribe();
    }
}
