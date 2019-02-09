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
                            <nav class="level">
                                <div class="level-left">
                                    <h4><a href="{{$thread->path()}}">{{$thread->title}}</a></h4>
                                </div>

                                <div class="level-right">
                                    <a href="{{$thread->path()}}">{{$thread->replies_count}}
                                        {{\Illuminate\Support\Str::plural('reply',$thread->replies_count)}}</a>
                                </div>
                            </nav>

                            <p>{{$thread->body}}</p>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection