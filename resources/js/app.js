require('./bootstrap')
const authorizations = require('./authorizations')

window.Vue = require('vue')

window.events = new Vue()
import InstantSearch from 'vue-instantsearch'

window.Vue.prototype.authorize = (...params) => {
    if (!window.shared.signedIn) return false

    if (typeof params[0] === 'string') {
        return authorizations[params[0]](params[1])
    }
    return params[0](window.shared.user)
}

window.Vue.prototype.signedIn = window.shared.signedIn

Vue.component('navigation-bar', require('./components/NavigationBar').default)
Vue.component('flash-message', require('./components/FlashMessage').default)
Vue.component('thread-view', require('./pages/ThreadView').default)
Vue.component('paginator-view', require('./components/PaginatorView').default)
Vue.component('avatar-form', require('./components/AvatarForm').default)
Vue.component('scan-view', require('./components/ScanView').default)
Vue.component('wysiwyg', require('./components/Wysiwyg').default)

Vue.use(InstantSearch)
const app = new Vue({
    el: '#app'
})
