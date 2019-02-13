<template>
    <nav
        v-if="shouldPaginate"
        class="pagination is-centered has-margin-bottom-15"
    >
        <a v-show="preUrl" class="pagination-previous" @click="page--"
            >Previous</a
        >
        <a v-show="nextUrl" class="pagination-next" @click="page++"
            >Next page</a
        >

        <ul class="pagination-list">
            <li><a class="pagination-link">1</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link" aria-label="Goto page 45">45</a></li>
            <li>
                <a class="pagination-link is-current">46</a>
            </li>
            <li><a class="pagination-link">47</a></li>
            <li><span class="pagination-ellipsis">&hellip;</span></li>
            <li><a class="pagination-link">86</a></li>
        </ul>
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
            this.broadcast()
        }
    },
    methods: {
        broadcast() {
            this.$emit('changed', this.page)
        }
    }
}
</script>
