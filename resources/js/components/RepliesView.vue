<template>
    <div>
        <div v-for="(reply, index) in replies" :key="reply.id">
            <reply-view :reply="reply" @deleted="deleted(index)"></reply-view>
        </div>
        <new-reply :endpoint="endpoint" @addedReply="newReply"></new-reply>
    </div>
</template>

<script>
import ReplyView from './ReplyView'
import NewReply from './NewReply'

export default {
    name: 'RepliesView',
    components: { ReplyView, NewReply },
    data() {
        return {
            replies: [],
            endpoint: location.pathname + '/replies'
        }
    },
    mounted() {
        this.fetch()
    },
    methods: {
        fetch() {
            axios.get(this.url()).then(this.refresh)
        },
        refresh({ data }) {
            console.log(data)
        },
        url() {
            return location.pathname + '/replies'
        },
        deleted(index) {
            this.replies.splice(index, 1)
            this.$emit('deleted')
        },
        newReply(reply) {
            this.replies.push(reply)
            this.$emit('added')
        }
    }
}
</script>
