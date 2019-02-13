<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply-view :reply="reply" @deleted="remove(index)"></reply-view>
        </div>
        <paginator-view :all="dataSet" @changed="test"></paginator-view>
        <new-reply :endpoint="endpoint" @addedReply="add"></new-reply>
    </div>
</template>

<script>
import ReplyView from './ReplyView'
import NewReply from './NewReply'
import collection from '../mixins/Collection'

export default {
    name: 'RepliesView',
    components: { ReplyView, NewReply },
    mixins: [collection],
    data() {
        return {
            dataSet: {},
            endpoint: location.pathname + '/replies'
        }
    },
    created() {
        this.fetch()
    },
    methods: {
        test(page) {
            axios.get(this.url(page)).then(this.refresh)
        },
        fetch(page) {
            axios.get(this.url(page)).then(this.refresh)
        },
        refresh({ data }) {
            this.dataSet = data
            this.items = data.data
        },
        url(page = 1) {
            return location.pathname + '/replies?page=' + page
        }
    }
}
</script>
