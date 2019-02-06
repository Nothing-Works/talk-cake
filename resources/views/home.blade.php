@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-mobile is-centered">
            <div class="column is-half">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Dashboard
                        </p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            @if (session('status'))
                                <div class="notification is-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif You are logged in!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection