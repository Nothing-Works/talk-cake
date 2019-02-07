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
    </div>
@endsection