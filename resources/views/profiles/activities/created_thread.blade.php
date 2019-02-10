@component('profiles.activities.activity')
    @slot('heading')
        {{$profileUser->name}} published
        <a href="{{$activity->subject->path()}}">{{$activity->subject->title}}</a>
    @endslot
    @slot('time')
        {{$activity->created_at->diffForHumans()}}
    @endslot
    @slot('body')
        <span>{{$activity->subject->body}}</span>
    @endslot
@endcomponent
