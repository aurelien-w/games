import Vue from 'vue'
import axios from 'axios'

import router from './routes'
window.axios = axios.create({
    baseURL: window.location.origin,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})

import App from './components/App.vue'

new Vue({
    el: '#app',
    components: { App },
    template: '<App/>'
    router
})