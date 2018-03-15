require('../css/app.scss');

import Vue from 'vue';

let vm = new Vue({
    el: '#app',
    data() {
        return {
            domFilter: "",
            extFilter: ""
        }
    },
    methods: {
        showSeasonDuelRow(domPlayer, extPlayer) {

            if (domPlayer !== "" && extPlayer === "") {
                let regex = new RegExp(this.domFilter, 'i');
                return domPlayer.match(regex)
            } else if (domPlayer === "" && extPlayer !== "") {
                let regex = new RegExp(this.extFilter, 'i');
                return extPlayer.match(regex)
            } else {
                let regexDom = new RegExp(this.domFilter, 'i');
                let regexExt = new RegExp(this.extFilter, 'i');
                return domPlayer.match(regexDom) && extPlayer.match(regexExt)
            }
        }
    }
});