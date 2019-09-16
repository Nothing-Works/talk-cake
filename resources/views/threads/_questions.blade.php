<div class="card has-margin-bottom-50" v-if="editing">
    <header class="card-header">
        <p class="card-header-title">
            <input type="text" class="input" v-model="form.title">
        </p>
    </header>
    <div class="card-content">
        <div class="content">
            <textarea class="textarea" rows="10" v-model="form.body"></textarea>
        </div>
    </div>
    <footer class="card-footer">
        <button class="card-footer-item" @click="save">Save</button>
        <button class="card-footer-item" @click="cancel">Cancel</button>
    </footer>
</div>
<div class="card has-margin-bottom-50" v-else>
    <header class="card-header">
        <p class="card-header-title">
            <img src="{{$thread->user->avatar_path}}" width="50" height="50"
                 alt="avatar">
            <a href="/profiles/{{$thread->user->name}}">{{$thread->user->name}}</a>&nbsp;
            <span>posted: </span> <span v-text="title"></span>
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
            <p v-text="body"></p>
        </div>
    </div>
    <footer class="card-footer" v-if="authorize('owns',dataThread)">
        <button class="card-footer-item" @click="editing = true">Edit</button>
    </footer>
</div>
