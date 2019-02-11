@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{$activity->subject->favorited->path()}}">
            {{$profileUser->name}} favorited a reply
            {{$activity->subject->favorited->thread->title}}</a>
    @endslot
    @slot('time')
        {{$activity->created_at->diffForHumans()}}
    @endslot
    @slot('body')
        <span>{{$activity->subject->favorited->body}}</span>
    @endslot
@endcomponent
