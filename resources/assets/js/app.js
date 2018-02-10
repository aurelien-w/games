import Vue from 'vue'

import router from './routes'
import store from './store'

import App from './components/App.vue'

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