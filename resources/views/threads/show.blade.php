@extends('layouts.app')

@section('content')
    <thread-view inline-template :count="{{$thread->replies_count}}">
        <div class="container">
            <div class="columns">
                <div class="column is-8">
                    <div class="card has-margin-bottom-50">
                        <header class="card-header">
                            <p class="card-header-title">
                                <a href="/profiles/{{$thread->user->name}}">{{$thread->user->name}}</a>&nbsp;
                                <span>posted: </span>
                                {{$thread->title}}
                            </p>
                            @can('delete',$thread)
                                <form action="{{$thread->path()}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="card-header-icon button is-large">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <p>{{$thread->body}}</p>
                            </div>
                        </div>
                    </div>

                    <replies-view @added="repliesCount++" :items="{{$thread->replies}}" @deleted="repliesCount--"></replies-view>
                    {{--{{$replies->links()}}--}}



                </div>

                <div class="column is-4">
                    <div class="card">
                        <div class="card-content">
                            <div class="content">
                                <p>This thread was published {{$thread->created_at->diffForHumans()}}
                                    by <a href="">{{$thread->user->name}}</a>,
                                    and currently
                                    has <span
                                            v-text="repliesCount"></span> {{\Illuminate\Support\Str::plural('comment',$thread->replies_count)}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
