<script>
import RepliesView from '../components/RepliesView'
import SubscribeButton from '../components/SubscribeButton'
export default {
    name: 'ThreadView',
    components: { RepliesView, SubscribeButton },
    props: {
        count: {
            type: Number,
            default: 0
        },
        dataLocked: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            locked: this.dataLocked,
            repliesCount: this.count
        }
    }
}
</script>
