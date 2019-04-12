<template>
    <input type="file" accept="image/*" @change="onChange" />
</template>

<script>
export default {
    name: 'ImageUpload',
    methods: {
        onChange(e) {
            if (!e.target.files.length) return

            const file = e.target.files[0]

            const reader = new FileReader()

            reader.readAsDataURL(file)

            reader.onload = e =>
                this.$emit('upload', {
                    src: e.target.result,
                    file
                })
        }
    }
}
</script>
