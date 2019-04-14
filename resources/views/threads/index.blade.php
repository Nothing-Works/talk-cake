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
                            <h1>Trending Threads</h1>
                        </div>
                    </header>
                    <div class="card-content">
                        <p>Something here</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection