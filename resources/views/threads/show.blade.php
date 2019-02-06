@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
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
            <div class="columns is-centered">
                <div class="column is-half">
                    <div class="card">
                        <header class="card-header">
                            <div class="card-header-title">
                                <a href="#">{{$reply->user->name}}</a>&nbsp;
                            <span>said {{$reply->created_at->diffForHumans()}}...</span>
                            </div>
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <span>{{$reply->body}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection