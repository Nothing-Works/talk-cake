<script>
export default {
    name: 'ReplyView',
    props: {
        reply: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            editing: false,
            body: this.reply.body
        }
    },
    mounted() {
        console.log('mounted')
    },
    methods: {
        showInput() {
            this.editing = true
        },
        cancel() {
            this.editing = false
            this.body = this.reply.body
        },
        save() {
            axios
                .patch(`/replies/${this.reply.id}`, { body: this.body })
                .then(response => {
                    this.body = response.data
                    this.editing = false
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped></style>
