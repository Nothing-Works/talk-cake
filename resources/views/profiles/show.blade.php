@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-8">
                <section class="hero">
                    <div class="hero-body">
                        <avatar-form :user="{{$profileUser}}"></avatar-form>
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