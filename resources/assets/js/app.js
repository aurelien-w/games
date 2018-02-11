import Vue from 'vue'

import router from './routes'
import store from './store'

// Helpers
window.Event = new Vue
window.flash = function (message, options = {}) {
    options = {
        type: 'is-danger',
        icon: 'fas fa-exclamation-triangle',
        channel: 'flash',
        fixed: {
            top: true,
            right: true,
            bottom: false,
            left: false
        },
        timeout: 3000,
        ...options
    }

    window.Event.$emit('flash', { ...options, message })
}

// Components
import App from './components/App'
import Modal from './components/Modal'
import Flash from './components/Flash'

Vue.component('Flash', Flash)
Vue.component('Modal', Modal)

Vue.mixin({
    data () {
        return {
            loading: false
        }
    },
    methods: {
        /**
         * Toggles loading state
         */
        toggleLoading() {
            this.loading = !this.loading
        }
    }
})

new Vue({
    el: '#app',
    components: { App },
    template: '<App/>',
    store,
    router
})