@extends('layouts.app')
@section('content')

    <thread-view inline-template :count="{{$thread->replies_count}}" :data-locked="@json($thread->locked)">
        <div class="container">
            <div class="columns">
                <div class="column is-8">
                    <div class="card has-margin-bottom-50">
                        <header class="card-header">
                            <p class="card-header-title">
                                <img src="{{$thread->user->avatar_path}}" width="50" height="50"
                                     alt="avatar">
                                <a href="/profiles/{{$thread->user->name}}">{{$thread->user->name}}</a>&nbsp;
                                <span>posted: </span> {{$thread->title}}
                            </p>
                            @can('delete',$thread)
                                <form action="{{$thread->path()}}" method="POST">
                                    @method('DELETE') @csrf
                                    <button type="submit" class="card-header-icon button is-large">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <p>{{$thread->body}}</p>
                            </div>
                        </div>
                    </div>
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

                                <button class="button" v-if="authorize('isAdmin') && !locked"
                                        @click="locked=true">
                                    Lock
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
