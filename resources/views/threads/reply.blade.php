<div class="card has-margin-bottom-25">
<header class="card-header">
    <div class="card-header-title">
        <a href="#">{{$reply->user->name}}</a>&nbsp;
        <span>said {{$reply->created_at->diffForHumans()}}...</span>
    </div>
</header>
<div class="card-content">
    <div class="content">
        <span>{{$reply->body}}</span>
    </div>
</div>
</div>
