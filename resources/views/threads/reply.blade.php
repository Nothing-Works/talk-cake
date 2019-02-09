<div class="card has-margin-bottom-25">
    <header class="card-header">
        <div class="card-header-title">
            <a href="#">{{$reply->user->name}}</a>&nbsp;
            <span>said {{$reply->created_at->diffForHumans()}}...</span>
        </div>

        <form action="/replies/{{$reply->id}}/favorites" method="POST">
            @csrf
            <button type="submit" class="button is-large has-text-danger" {{$reply->isFavorited() ? 'disabled':''}} >
                {{$reply->favorites()->count()}} {{\Illuminate\Support\Str::plural('Favorite',$reply->favorites()->count())}}
                <i class="far fa-heart"></i>
            </button>
        </form>
    </header>
    <div class="card-content">
        <div class="content">
            <span>{{$reply->body}}</span>
        </div>
    </div>
</div>
