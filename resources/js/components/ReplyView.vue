<template>
    <div :id="'reply-' + id" class="card has-margin-bottom-25">
        <header class="card-header">
            <div class="card-header-title">
                <a
                    :href="'/profiles/' + reply.user.name"
                    v-text="reply.user.name"
                ></a>
                <span>said {{ reply.created_at }}...</span>
            </div>
            <favorite-button :reply="reply"></favorite-button>
        </header>
        <div class="card-content">
            <div class="content">
                <div v-if="editing">
                    <div class="field">
                        <div class="control">
                            <textarea
                                v-model="body"
                                aria-label="body"
                                class="textarea"
                            ></textarea>
                        </div>
                    </div>
                </div>
                <span v-else v-text="body"></span>
            </div>
        </div>
        <!--@can('delete',$reply)-->
        <footer class="card-footer">
            <button
                type="button"
                class="button is-large has-text-info"
                @click="destroy"
            >
                Delete
            </button>

            <div v-if="editing">
                <button
                    type="button"
                    class="button is-large has-text-info"
                    @click="save"
                >
                    Save
                </button>
                <button
                    type="button"
                    class="button is-large has-text-info"
                    @click="cancel"
                >
                    Cancel
                </button>
            </div>
            <button
                v-else
                type="button"
                class="button is-large has-text-info"
                @click="showInput"
            >
                edit
            </button>
        </footer>
        <!--@endcan-->
    </div>
</template>
<script>
import FavoriteButton from './FavoriteButton'
export default {
    name: 'ReplyView',
    components: { FavoriteButton },
    props: {
        reply: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            id: this.reply.id,
            editing: false,
            body: this.reply.body
        }
    },
    mounted() {
        console.log('mounted')
    },
    methods: {
        showInput() {
            this.editing = true
        },
        cancel() {
            this.editing = false
            this.body = this.reply.body
        },
        save() {
            axios
                .patch(`/replies/${this.reply.id}`, { body: this.body })
                .then(response => {
                    this.body = response.data
                    this.editing = false
                })
                .catch(error => {
                    console.log(error)
                })
        },
        destroy() {
            axios
                .delete(`/replies/${this.reply.id}`)
                .then(response => {
                    this.$emit('deleted', this.id)
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>
