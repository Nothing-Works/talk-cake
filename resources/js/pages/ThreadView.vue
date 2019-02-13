<script>
import RepliesView from '../components/RepliesView'
export default {
    name: 'ThreadView',
    components: { RepliesView },
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
