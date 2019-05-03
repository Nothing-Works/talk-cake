/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap')
const authorizations = require('./authorizations')

window.Vue = require('vue')

window.Vue.prototype.authorize = (...params) => {
    if (!window.shared.signedIn) return false

    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1])
    }
    return params[0](window.shared.user)
}

window.Vue.prototype.signedIn = window.shared.signedIn
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/NavigationBar.vue -> <example-component></example-component>
 */
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('navigation-bar', require('./components/NavigationBar').default)
Vue.component('flash-message', require('./components/FlashMessage').default)
Vue.component('thread-view', require('./pages/ThreadView').default)
Vue.component('paginator-view', require('./components/PaginatorView').default)
Vue.component('avatar-form', require('./components/AvatarForm').default)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app'
})
