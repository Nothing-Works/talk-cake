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
            channel: this.dataThread.channel.slug,
            slug: this.dataThread.slug,
            editing: false,
            title: this.dataThread.title,
            body: this.dataThread.body,
            form: {
                title: this.dataThread.title,
                body: this.dataThread.body
            }
        }
    },
    methods: {
        cancel() {
            this.form.title = this.title
            this.form.body = this.body
            this.editing = false
        },
        save() {
            const uri = `/threads/${this.channel}/${this.slug}`
            axios.patch(uri, this.form).then(({ data }) => {
                this.title = data.title
                this.body = data.body
                this.editing = false
            })
        },
        toggleThread() {
            axios[this.locked ? 'delete' : 'post'](
                `/lock-thread/${this.slug}`
            ).then(() => (this.locked = !this.locked))
        }
    }
}
</script>
