<template>
    <div
        v-if="notifications.length"
        class="navbar-item has-dropdown is-hoverable"
    >
        <a class="navbar-link">
            Notifications
        </a>
        <div class="navbar-dropdown">
            <div v-for="notification in notifications" :key="notification.id">
                <a
                    :href="notification.data.link"
                    class="navbar-item"
                    @click="read(notification.id)"
                >
                    {{ notification.data.message }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UserNotifications',
    data() {
        return {
            notifications: []
        }
    },
    mounted() {
        axios
            .get('/profiles/' + window.shared.user.name + '/notifications')
            .then(response => (this.notifications = response.data))
    },
    methods: {
        read(id) {
            axios.delete(
                '/profiles/' + window.shared.user.name + '/notifications/' + id
            )
        }
    }
}
</script>
