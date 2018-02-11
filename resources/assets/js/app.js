import Vue from 'vue'

import router from './routes'
import store from './store'

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