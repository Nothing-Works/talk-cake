<template>
    <div v-show="show" class="notification is-success position">
        <button class="delete" @click="dismiss"></button>
        <strong>Success !!!</strong> {{ body }}
    </div>
</template>

<script>
export default {
    name: 'FlashMessage',
    props: {
        message: {
            type: String,
            default: 'Flash  Default'
        }
    },
    data() {
        return {
            body: this.message,
            show: false
        }
    },
    created() {
        if (this.message) {
            this.show = true
        }
    },
    methods: {
        dismiss() {
            this.show = false
        }
    }
}
</script>

<style scoped>
.position {
    position: fixed;
    right: 25px;
    bottom: 25px;
}
</style>
