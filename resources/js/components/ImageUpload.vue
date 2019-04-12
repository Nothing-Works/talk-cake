<template>
    <div class="file">
        <label class="file-label">
            <input
                class="file-input"
                type="file"
                accept="image/*"
                @change="onChange"
            />
            <span class="file-cta">
                <span class="file-icon">
                    <i class="fas fa-upload"></i>
                </span>
                <span class="file-label">
                    Choose a image…
                </span>
            </span>
        </label>
    </div>
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
