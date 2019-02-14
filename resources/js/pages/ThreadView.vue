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
        }
    },
    data() {
        return {
            repliesCount: this.count
        }
    }
}
</script>
