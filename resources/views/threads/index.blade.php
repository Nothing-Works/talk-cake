@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                @forelse($threads as $thread)
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
                                <a href="{{$thread->path()}}">{{$thread->title}}</a>
                            </p>
                            <a class="card-header-icon" href="{{$thread->path()}}">{{$thread->replies_count}}
                                {{\Illuminate\Support\Str::plural('reply',$thread->replies_count)}}</a>
                        </header>
                        <div class="card-content">
                            <p>{{$thread->body}}</p>
                        </div>
                        <hr>
                    </div>
                    @empty
                    <h1>There is no thread yet</h1>
                @endforelse
            </div>
        </div>
    </div>
@endsection