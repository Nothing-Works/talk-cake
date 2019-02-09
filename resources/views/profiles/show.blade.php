@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-8">
                <section class="hero">
                    <div class="hero-body">
                        <h1 class="title">
                            {{$profileUser->name}}
                        </h1>
                        <h2 class="subtitle">
                            Since {{$profileUser->created_at->diffForHumans()}}
                        </h2>
                    </div>
                </section>
                <hr>
                @foreach($threads as $thread)
                    <div class="card has-margin-bottom-25">
                        <header class="card-header">
                            <div class="card-header-title">
                                <a href="#">{{$thread->user->name}}</a>&nbsp;
                                <span>posted: {{$thread->title}}</span>
                            </div>
                            <p class="card-header-icon">
                            <span class="content">
                                {{$thread->created_at->diffForHumans()}}
                            </span>
                            </p>
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <span>{{$thread->body}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{$threads->links()}}
            </div>
        </div>
    </div>
@endsection