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
    props: {
        items: {
            type: Array,
            default() {
                return []
            }
        }
    },
    data() {
        return {
            replies: this.items,
            endpoint: location.pathname + '/replies'
        }
    },
    mounted() {},
    methods: {
        deleted(index) {
            this.replies.splice(index, 1)
            this.$emit('deleted')
        },
        newReply(reply) {
            this.items.push(reply)
            this.$emit('added')
        }
    }
}
</script>
