@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            <a href="#">{{$thread->user->name}}</a>&nbsp;
                            <span>posted: </span>
                            {{$thread->title}}
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p>{{$thread->body}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($thread->replies as $reply)
            @include('threads.reply')
        @endforeach


        <div class="columns is-centered">
            <div class="column is-half">
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
        </div>
    </div>
@endsection