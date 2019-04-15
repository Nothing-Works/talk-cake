@forelse($threads as $thread)
    <div class="card">
        <header class="card-header">
            <div class="card-header-title">
                <div class="media-content">
                    <a class="{{ auth()->check()&&$thread->hasUpdate() ? 'has-text-success' : ''}}"
                       href="{{$thread->path()}}">{{$thread->title}}</a>
                    <p>Posted By: <a href="/profiles/{{$thread->user->name}}">{{$thread->user->name}}</a>
                    </p>
                </div>
            </div>

            <a class="card-header-icon" href="{{$thread->path()}}">{{$thread->replies_count}}
                {{\Illuminate\Support\Str::plural('reply',$thread->replies_count)}}</a>
        </header>
        <div class="card-content">
            <p>{{$thread->body}}</p>

        </div>
        <footer class="card-footer">
            <p class="card-footer-item">{{$thread->visits()}} Visits</p>
        </footer>
    </div>
    <hr>

@empty
    <h1>There is no thread yet</h1>
@endforelse