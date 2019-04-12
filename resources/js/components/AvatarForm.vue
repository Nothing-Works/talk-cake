<template>
    <div>
        <div class="card-content">
            <div class="media">
                <div class="media-left">
                    <figure class="image is-48x48">
                        <img
                            :src="avatar"
                            width="50"
                            height="50"
                            alt="avatar"
                        />
                    </figure>
                </div>
                <div class="media-content">
                    <h1 class="title" v-text="profileUser.name"></h1>
                    <div class="content">
                        <form
                            v-if="canUpdate"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            <image-upload @upload="uploaded"></image-upload>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
