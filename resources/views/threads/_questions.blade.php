<div class="card has-margin-bottom-50" v-if="editing">
    <header class="card-header">
        <p class="card-header-title">
            <input type="text" class="input" value="{{$thread->title}}">
        </p>
    </header>
    <div class="card-content">
        <div class="content">
            <textarea class="textarea" rows="10">{{$thread->body}}</textarea>
        </div>
    </div>
    <footer class="card-footer">
        <button class="card-footer-item" @click="editing = false">Save</button>
        <button class="card-footer-item" @click="editing = false">Cancel</button>
    </footer>
</div>
<div class="card has-margin-bottom-50" v-else>
    <header class="card-header">
        <p class="card-header-title">
            <img src="{{$thread->user->avatar_path}}" width="50" height="50"
                 alt="avatar">
            <a href="/profiles/{{$thread->user->name}}">{{$thread->user->name}}</a>&nbsp;
            <span>posted: </span> {{$thread->title}}
        </p>
        @can('delete',$thread)
            <form action="{{$thread->path()}}" method="POST">
                @method('DELETE') @csrf
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
    {{--    @can('update',$thread)--}}
    <footer class="card-footer">
        <button class="card-footer-item" @click="editing = true">Edit</button>
    </footer>
    {{--    @endcan--}}
</div>
