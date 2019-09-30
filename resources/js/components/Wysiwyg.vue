<template>
    <div>
        <input id="trix" type="hidden" :name="name" :value="value" />
        <trix-editor
            :id="id"
            ref="trix"
            input="trix"
            :placeholder="placeholder"
        ></trix-editor>
    </div>
</template>
<script>
import Trix from 'trix'
import 'trix/dist/trix.css'
export default {
    props: {
        name: {
            type: String,
            default: null
        },
        id: {
            type: String,
            default: null
        },
        shouldClear: {
            type: Boolean,
            default: null
        },
        value: {
            type: String,
            default: null
        },
        placeholder: {
            type: String,
            default: null
        }
    },
    mounted() {
        this.$refs.trix.addEventListener('trix-change', e => {
            this.$emit('input', e.target.innerHTML)
        })

        this.$watch('shouldClear', () => (this.$refs.trix.value = ''))
    }
}
</script>
