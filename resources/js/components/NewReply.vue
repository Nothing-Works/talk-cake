<template>
    <div v-if="signedIn">
        <div class="field">
            <div class="control">
                <textarea
                    id="input"
                    v-model="body"
                    name="body"
                    class="textarea"
                    placeholder="Leave a reply"
                ></textarea>
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
            body: ''
        }
    },
    computed: {
        signedIn() {
            return window.shared.signedIn
        }
    },

    mounted() {
        const tribute = new Tribute({
            values: (text, cb) => this.fetchUser(text, cb),
            lookup: 'name',
            fillAttr: 'name'
        })
        tribute.attach(document.getElementById('input'))
    },
    methods: {
        submit() {
            axios
                .post(this.endpoint, { body: this.body })
                .then(({ data }) => {
                    this.body = ''
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
</style>
