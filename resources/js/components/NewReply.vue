<template>
    <div v-if="signedIn">
        <div class="field">
            <div class="control">
                <textarea
                    id="input"
                    v-model="body"
                    name="body"
                    class="textarea"
                    placeholder="Leave a reply"
                ></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button class="button is-link" @click="submit">Submit</button>
            </div>
        </div>
    </div>
    <h1 v-else>U need to <a href="/login">sign in</a></h1>
</template>

<script>
import Tribute from 'tributejs'
export default {
    name: 'NewReply',
    props: {
        endpoint: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            body: ''
        }
    },
    computed: {
        signedIn() {
            return window.shared.signedIn
        }
    },

    mounted() {
        const tribute = new Tribute({
            trigger: '@',
            iframe: null,
            selectClass: 'highlight',
            selectTemplate: function(item) {
                return '@' + item.original.value
            },
            menuItemTemplate: function(item) {
                return item.string
            },
            noMatchTemplate: null,
            menuContainer: document.body,
            lookup: 'key',
            fillAttr: 'value',
            values: [
                { key: 'Phil Heartman', value: 'pheartman' },
                { key: 'Gordon Ramsey', value: 'gramsey' },
                { key: 'Gordon Ramsey', value: 'gramsey' },
                { key: 'Gordon Ramsey', value: 'gramsey' },
                { key: 'Gordon Ramsey', value: 'gramsey' },
                { key: 'Gordon Ramsey', value: 'gramsey' }
            ],
            requireLeadingSpace: true,
            allowSpaces: false,
            replaceTextSuffix: '\n',
            positionMenu: true,
            spaceSelectsMatch: false,
            autocompleteMode: false,
            searchOpts: {
                pre: '<span>',
                post: '</span>'
            }
        })
        tribute.attach(document.getElementById('input'))
    },
    methods: {
        submit() {
            axios
                .post(this.endpoint, { body: this.body })
                .then(({ data }) => {
                    this.body = ''
                    this.$emit('addedReply', data)
                })
                .catch(error => {
                    alert(error.response.data.message)
                })
        }
    }
}
</script>

<style>
/*@import '~tributejs/dist/tribute.css';*/

.tribute-container {
    position: absolute;
    top: 0;
    left: 0;
    height: auto;
    max-height: 300px;
    max-width: 500px;
    overflow: auto;
    display: block;
    z-index: 999999;
}
.tribute-container ul {
    margin: 0;
    margin-top: 2px;
    padding: 0;
    list-style: none;
    background: #efefef;
}
.tribute-container li {
    padding: 5px 5px;
    cursor: pointer;
}
.tribute-container li.highlight {
    background: #ddd;
}
.tribute-container li span {
    font-weight: bold;
}
.tribute-container li.no-match {
    cursor: default;
}
.tribute-container .menu-highlighted {
    font-weight: bold;
}
</style>
