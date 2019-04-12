<template>
    <div>
        <h1 class="title" v-text="profileUser.name"></h1>
        <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
            <input
                type="file"
                name="avatar"
                accept="image/*"
                @change="onChange"
            />
        </form>
        <img :src="avatar" width="50" height="50" alt="avatar" />
    </div>
</template>

<script>
export default {
    name: 'AvatarForm',
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
        onChange(e) {
            if (!e.target.files.length) return

            const avatar = e.target.files[0]

            const reader = new FileReader()

            reader.readAsDataURL(avatar)

            reader.onload = e => (this.avatar = e.target.result)

            this.persist(avatar)
        },
        persist(avatar) {
            const data = new FormData()
            data.append('avatar', avatar)
            axios
                .post(`/api/users/${this.profileUser.id}/avatar`, data)
                .then(() => console.log('uploaded'))
        }
    }
}
</script>

<!--action="/api/users/{{profileUser.id}}/avatar"-->
