<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply-view :reply="reply" @deleted="remove(index)"></reply-view>
        </div>
        <paginator-view :all="dataSet"></paginator-view>
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
    mounted() {
        this.fetch()
    },
    methods: {
        fetch() {
            axios.get(this.url()).then(this.refresh)
        },
        refresh({ data }) {
            console.log(data)
            this.dataSet = data
            this.items = data.data
        },
        url() {
            return location.pathname + '/replies'
        }
    }
}
</script>
