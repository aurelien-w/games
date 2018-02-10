import Vue from 'vue'
import axios from 'axios'

import router from './routes'

import App from './components/App.vue'

window.axios = axios.create({
    baseURL: window.location.origin + '/api/',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})

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
    router
})