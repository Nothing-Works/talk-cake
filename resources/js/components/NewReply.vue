<template>
    <div v-if="signedIn">
        <div class="field">
            <div class="control">
                <textarea
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
    methods: {
        submit() {
            axios
                .post(this.endpoint, { body: this.body })
                .then(({ data }) => {
                    this.body = ''
                    this.$emit('addedReply', data)
                })
                .catch(error => {
                    alert(error.response.data)
                })
        }
    }
}
</script>
