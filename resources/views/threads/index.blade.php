@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Forum Threads
                        </p>
                    </header>
                    @foreach($threads as $thread)
                        <div class="card-content">
                            <div class="content">
                                <h4><a href="{{$thread->path()}}">{{$thread->title}}</a></h4>
                                <p>{{$thread->body}}</p>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection