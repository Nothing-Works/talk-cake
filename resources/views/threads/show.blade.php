@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column is-8">
                <div class="card has-margin-bottom-50">
                    <header class="card-header">
                        <p class="card-header-title">
                            <a href="/profiles/{{$thread->user->name}}">{{$thread->user->name}}</a>&nbsp;
                            <span>posted: </span>
                            {{$thread->title}}
                        </p>
                        <form action="{{$thread->path()}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="card-header-icon button is-large">
                             Delete
                            </button>
                        </form>

                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p>{{$thread->body}}</p>
                        </div>
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{$replies->links()}}
                @auth
                    <form action="{{$thread->path()}}/replies" method="POST">
                        @csrf
                        <div class="field">
                            <div class="control">
                                <textarea name="body" class="textarea" placeholder="Leave a reply"></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-link">Submit</button>
                            </div>
                        </div>
                    </form>
                @else
                    <h1>U need to <a href="{{route('login')}}">sign in</a></h1>
                @endauth
            </div>

            <div class="column is-4">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <p>This thread was published {{$thread->created_at->diffForHumans()}}
                                by <a href="">{{$thread->user->name}}</a>,
                                and currently
                                has {{$thread->replies_count}} {{\Illuminate\Support\Str::plural('comment',$thread->replies_count)}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection