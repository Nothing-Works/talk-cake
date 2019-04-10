@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-half">
                @include('threads._list')

                {{$threads->links()}}
            </div>
        </div>
    </div>
@endsection