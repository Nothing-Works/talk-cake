<reply-view inline-template v-cloak :reply="{{$reply}}">
    <div v-if="show" id="reply-{{$reply->id}}" class="card has-margin-bottom-25">
        <header class="card-header">
            <div class="card-header-title">
                <a href="/profiles/{{$reply->user->name}}">{{$reply->user->name}}</a>&nbsp;
                <span>said {{$reply->created_at->diffForHumans()}}...</span>
            </div>
            <favorite-button :reply="{{$reply}}"></favorite-button>
        </header>
        <div class="card-content">
            <div class="content">
                <div v-if="editing">
                    <div class="field">
                        <div class="control">
                            <textarea aria-label="body" class="textarea" v-model="body"></textarea>
                        </div>
                    </div>
                </div>
                <span v-else v-text="body"></span>
            </div>
        </div>
        @can('delete',$reply)
            <footer class="card-footer">
                <button type="button" @click="destroy" class="button is-large has-text-info">
                    Delete
                </button>

                <div v-if="editing">
                    <button type="button" @click="save" class="button is-large has-text-info">
                        Save
                    </button>
                    <button type="button" @click="cancel" class="button is-large has-text-info">
                        Cancel
                    </button>
                </div>
                <button v-else type="button" @click="showInput" class="button is-large has-text-info">
                    edit
                </button>
            </footer>
        @endcan
    </div>
</reply-view>