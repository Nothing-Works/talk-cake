<script>
import UserNotifications from './UserNotifications'

export default {
    name: 'NavigationBar',
    components: {
        UserNotifications
    },
    data() {
        return {
            show: false
        }
    },
    methods: {
        toggle() {
            this.show = !this.show
        }
    }
}
</script>

<style scoped></style>
