@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column is-8">
                @include('threads._list')

                {{$threads->links()}}
            </div>

            <div class="column is-4">
                <div class="card">
                    <header class="card-header">
                        <div class="card-header-title">
                            <h1>Search</h1>
                        </div>
                    </header>
                    <div class="card-content">
                        <form method="GET" action="/threads/search">
                            <input type="text" placeholder="Search for something..." name="query" class="input has-margin-bottom-5">
                            <button type="submit" class="button is-link">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <header class="card-header">
                        <div class="card-header-title">
                            <h1>Trending Threads</h1>
                        </div>
                    </header>
                    <div class="card-content">
                        @forelse($trending as $thread)
                            <li class="panel-block">
                                <a href="{{url($thread->path)}}">{{$thread->title}}</a>
                            </li>
                        @empty
                            <h1>There is not trending threads</h1>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
