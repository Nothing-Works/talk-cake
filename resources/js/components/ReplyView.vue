<template>
    <div :id="'reply-' + id" class="card has-margin-bottom-25">
        <header
            class="card-header"
            :class="isBest ? 'has-background-success' : ''"
        >
            <div class="card-header-title">
                <a
                    :href="'/profiles/' + reply.user.name"
                    v-text="reply.user.name"
                ></a>
                <p>said <span v-text="ago"></span></p>
            </div>
            <favorite-button v-if="signedIn" :reply="reply"></favorite-button>
        </header>
        <form @submit.prevent="save">
            <div class="card-content">
                <div class="content">
                    <div v-if="editing">
                        <div class="field">
                            <div class="control">
                                <textarea
                                    v-model="body"
                                    aria-label="body"
                                    class="textarea"
                                    required
                                ></textarea>
                            </div>
                        </div>
                    </div>
                    <span v-else v-html="body"></span>
                </div>
            </div>
            <footer class="card-footer level">
                <div v-if="authorize('owns', reply)">
                    <div class="level-left">
                        <button
                            type="button"
                            class="button is-large has-text-info"
                            @click="destroy"
                        >
                            Delete
                        </button>

                        <div v-if="editing">
                            <button
                                type="submit"
                                class="button is-large has-text-info"
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
                    </div>
                </div>

                <div v-if="authorize('owns', reply.thread)" class="level-right">
                    <button
                        v-if="!isBest"
                        type="button"
                        class="button is-large has-text-info"
                        @click="markBestReply"
                    >
                        Best Reply?
                    </button>
                </div>
            </footer>
        </form>
    </div>
</template>
<script>
import FavoriteButton from './FavoriteButton'
import moment from 'moment'

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
            body: this.reply.body,
            isBest: this.reply.isBest,
            data: this.reply
        }
    },
    computed: {
        ago() {
            return moment
                .utc(this.reply.created_at)
                .local()
                .fromNow()
        }
    },
    created() {
        console.log(this.reply.thread.user_id)
        window.events.$on(
            'best-reply-selected',
            id => (this.isBest = id === this.id)
        )
    },
    methods: {
        markBestReply() {
            axios
                .post(`/replies/${this.id}/best`)
                .then(() => {
                    window.events.$emit('best-reply-selected', this.id)
                })
                .catch(error => {
                    alert(error.response.data.message)
                })
        },
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
                    alert(error.response.data.message)
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
