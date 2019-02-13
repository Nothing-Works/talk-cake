<template>
    <div>
        <div v-for="(reply, index) in replies" :key="reply.id">
            <reply-view :reply="reply" @deleted="deleted(index)"></reply-view>
        </div>
    </div>
</template>

<script>
import ReplyView from './ReplyView'

export default {
    name: 'RepliesView',
    components: { ReplyView },
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
            replies: this.items
        }
    },
    mounted() {},
    methods: {
        deleted(index) {
            this.replies.splice(index, 1)
            this.$emit('deleted')
        }
    }
}
</script>
