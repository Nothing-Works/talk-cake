@extends('layouts.app')
@section('content')

    <thread-view inline-template :data-thread="{{$thread}}">
        <div class="container">
            <div class="columns">
                <div class="column is-8" v-cloak>
                    @include('threads._questions')
                    <replies-view @added="repliesCount++" @deleted="repliesCount--"></replies-view>
                </div>
                <div class="column is-4">
                    <div class="card">
                        <div class="card-content">
                            <div class="content">
                                <p>This thread was published {{$thread->created_at->diffForHumans()}} by <a
                                            href="">{{$thread->user->name}}</a>,
                                    and currently has <span v-text="repliesCount"></span>
                                    {{\Illuminate\Support\Str::plural('comment',$thread->replies_count)}}
                                </p>
                                <subscribe-button :subscribed=@json($thread->isSubscribed)></subscribe-button>

                                <button class="button" v-if="authorize('isAdmin')"
                                        @click="toggleThread" v-text="locked ? 'Unlock':'Lock'"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
