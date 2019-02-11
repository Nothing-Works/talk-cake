<template>
    <div class="notification is-success position">
        <button class="delete"></button>
        <strong>Success !!!</strong> {{ body }}
    </div>
</template>

<script>
export default {
    name: 'FlashMessage',
    props: {
        message: {
            type: String,
            default: 'Flash default'
        }
    },
    data() {
        return {
            body: this.message
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
