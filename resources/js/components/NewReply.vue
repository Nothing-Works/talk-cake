<template>
    <div v-if="signedIn">
        <div class="field">
            <div class="control">
                <wysiwyg
                    :id="id"
                    v-model="body"
                    name="body"
                    placeholder="Have something to say?"
                    :should-clear="completed"
                ></wysiwyg>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="button is-link" @click="submit">Submit</button>
            </div>
        </div>
    </div>
    <h1 v-else>U need to <a href="/login">sign in</a></h1>
</template>

<script>
import Tribute from 'tributejs'

export default {
    name: 'NewReply',
    props: {
        endpoint: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            body: '',
            completed: false,
            id: 'input'
        }
    },

    mounted() {
        const tribute = new Tribute({
            values: (text, cb) => this.fetchUser(text, cb),
            lookup: 'name',
            fillAttr: 'name',
            allowSpaces: true
        })
        tribute.attach(document.getElementById(this.id))
    },
    methods: {
        submit() {
            axios
                .post(this.endpoint, { body: this.body })
                .then(({ data }) => {
                    this.body = ''
                    this.completed = true
                    this.$emit('addedReply', data)
                })
                .catch(error => {
                    alert(error.response.data.message)
                })
        },
        fetchUser(text, cb) {
            axios
                .get(`/api/users?name=${text}`)
                .then(function(response) {
                    console.log(response)
                    cb(response.data)
                })
                .catch(function(error) {
                    console.log(error)
                    cb([])
                })
        }
    }
}
</script>

<style>
@import '~tributejs/dist/tribute.css';
@import '~trix/dist/trix.css';
</style>
