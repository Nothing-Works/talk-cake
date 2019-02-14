<template>
    <div>
        <button :class="['button', active ? 'is-danger' : '']" @click="toggle">
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
        toggle() {
            axios[this.active ? 'delete' : 'post'](
                location.pathname + '/subscriptions'
            )
            this.active = !this.active
        }
    }
}
</script>
