<template>
    <nav v-if="shouldPaginate" class="pagination has-margin-bottom-15">
        <a v-show="preUrl" class="pagination-previous" @click="page--"
            >Previous</a
        >
        <a v-show="nextUrl" class="pagination-next" @click="page++"
            >Next page</a
        >
    </nav>
</template>

<script>
export default {
    name: 'PaginatorView',
    props: {
        all: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            page: 1,
            preUrl: false,
            nextUrl: false
        }
    },
    computed: {
        shouldPaginate() {
            return !!this.preUrl || !!this.nextUrl
        }
    },
    watch: {
        all() {
            this.page = this.all.current_page
            this.preUrl = this.all.prev_page_url
            this.nextUrl = this.all.next_page_url
        },
        page() {
            this.broadcast().updateUrl()
        }
    },
    methods: {
        broadcast() {
            return this.$emit('changed', this.page)
        },
        updateUrl() {
            history.pushState(null, null, '?page=' + this.page)
        }
    }
}
</script>
