<template>
    <div>
        <button :class="classes" @click="toggle">
            Favorite
            <span v-text="favoritesCount"></span>
        </button>
    </div>
</template>

<script>
export default {
    name: 'FavoriteButton',
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
            id: this.reply.id,
            favoritesCount: this.reply.favoritesCount,
            isFavorited: this.reply.isFavorited
        }
    },
    computed: {
        classes() {
            return ['button', this.isFavorited ? 'is-black' : '']
        }
    },
    methods: {
        toggle() {
            if (this.isFavorited) {
                axios.delete(`/replies/${this.id}/favorites`)
                this.isFavorited = false
                this.favoritesCount--
            } else {
                axios.post(`/replies/${this.id}/favorites`)
                this.favoritesCount++
                this.isFavorited = true
            }
        }
    }
}
</script>

<style scoped></style>
