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
                        @can('update',$profileUser)
                            <form action="/api/users/{{$profileUser->id}}/avatar" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="avatar">
                                <button type="submit">Upload</button>
                            </form>
                            @include('layouts.errors')
                        @endcan
                        <img src="{{$profileUser->avatar()}}" width="50" height="50"
                             alt="avatar">
                    </div>
                </section>
                <hr>
                @forelse($activities as $date => $activity)
                    <div class="content">
                        <h1>{{$date}}</h1>
                    </div>
                    @foreach($activity as $record)
                        @if(view()->exists('profiles.activities.'.$record->type))
                            @include('profiles.activities.'.$record->type,['activity'=>$record])
                        @endif
                    @endforeach
                @empty
                    <p>Nothing to show</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection