@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content is-large has-text-centered">
            <h1>Welcome</h1>
            @auth
                <a class="button is-link" href="{{ url('/home') }}">Home</a> @else
                <a class="button is-warning" href="{{ route('register') }}">Get Started</a> @endauth
        </div>
    </div>
@endsection
