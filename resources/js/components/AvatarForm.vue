<template>
    <div>
        <h1 class="title" v-text="profileUser.name"></h1>
        <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
            <image-upload @upload="uploaded"></image-upload>
        </form>
        <img :src="avatar" width="50" height="50" alt="avatar" />
    </div>
</template>

<script>
import ImageUpload from './ImageUpload'
export default {
    name: 'AvatarForm',
    components: { ImageUpload },
    props: {
        user: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            profileUser: this.user,
            avatar: this.user.avatar_path
        }
    },
    computed: {
        canUpdate() {
            return this.authorize(user => user.id === this.profileUser.id)
        }
    },
    methods: {
        uploaded(object) {
            const data = new FormData()
            data.append('avatar', object.file)
            axios
                .post(`/api/users/${this.profileUser.id}/avatar`, data)
                .then(() => (this.avatar = object.src))
        }
    }
}
</script>

<!--action="/api/users/{{profileUser.id}}/avatar"-->
