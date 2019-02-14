<template>
    <div>
        <button
            :class="['button', active ? 'is-danger' : '']"
            @click="subscribe"
        >
            Subscribe
        </button>
    </div>
</template>

<script>
export default {
    props: {
        subscribed: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            active: this.subscribed
        }
    },
    methods: {
        subscribe() {
            axios.post(location.pathname + '/subscriptions')
            this.active = true
        }
    }
}
</script>
