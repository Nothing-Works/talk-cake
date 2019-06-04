<script>
import RepliesView from '../components/RepliesView'
import SubscribeButton from '../components/SubscribeButton'
export default {
    name: 'ThreadView',
    components: { RepliesView, SubscribeButton },
    props: {
        dataThread: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            locked: this.dataThread.locked,
            repliesCount: this.dataThread.count,
            slug: this.dataThread.slug
        }
    },
    methods: {
        toggleThread() {
            axios[this.locked ? 'delete' : 'post'](
                `/lock-thread/${this.slug}`
            ).then(() => (this.locked = !this.locked))
        }
    }
}
</script>
