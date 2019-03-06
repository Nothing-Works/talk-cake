<template>
    <div :id="'reply-' + id" class="card has-margin-bottom-25">
        <header class="card-header">
            <div class="card-header-title">
                <a
                    :href="'/profiles/' + reply.user.name"
                    v-text="reply.user.name"
                ></a>
                <p>said <span v-text="ago"></span></p>
            </div>
            <favorite-button v-if="signedIn" :reply="reply"></favorite-button>
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
        <footer v-if="canUpdate" class="card-footer">
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
            body: this.reply.body
        }
    },
    computed: {
        signedIn() {
            return window.shared.signedIn
        },
        canUpdate() {
            return this.authorize(user => this.reply.user_id === user.id)
        },
        ago() {
            return moment
                .utc(this.reply.created_at)
                .local()
                .fromNow()
        }
    },
    mounted() {
        console.log('mounter')
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
